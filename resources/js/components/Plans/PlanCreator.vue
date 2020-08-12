<template>
    <div class="PlanCreator">

        <div class="stage-indicator">
            <span :class="{'selected': selectedStage === 1}">1</span>
            <span :class="{'selected': selectedStage === 2}">2</span>
            <span :class="{'selected': selectedStage === 3}">3</span>
            <span :class="{'selected': selectedStage === 4}">4</span>
        </div>

        <div class="stage-heading">
            <span v-if="selectedStage === 1">Select your meals</span>
            <span v-if="selectedStage === 2">Edit your selected meals</span>
            <span v-if="selectedStage === 3">Adjust for anything you already have</span>
            <span v-if="selectedStage === 4">Final review</span>
        </div>

        <div class="stage" v-if="selectedStage === 1">
            <meal-selection :meals="meals"
                            :selectedMeals="selectedMeals"
            ></meal-selection>

            <button class="Button is-primary" @click="advanceStage">
                Next
            </button>
        </div>

        <div class="stage" v-if="selectedStage === 2">
            <meal-ingredients :meals="meals"
                              :selectedMeals="selectedMeals"
                              :items="items"
            ></meal-ingredients>

            <div class="buttons">
                <button class="Button is-secondary" @click="goBackAStage">
                    Back
                </button>

                <button class="Button is-primary" @click="advanceStage">
                    Next
                </button>
            </div>
        </div>

        <div class="stage" v-if="selectedStage === 3">
            <cupboard-items :items="items"
                            :itemAmounts="itemAmounts"
            ></cupboard-items>

            <div class="buttons">
                <button class="Button is-secondary" @click="goBackAStage">
                    Back
                </button>

                <button class="Button is-primary" @click="advanceStage">
                    Next
                </button>
            </div>

        </div>

        <div class="stage" v-if="selectedStage === 4">
            <final-review :items="items"
                          :itemAmounts="itemAmounts"
                          :locations="locations"
                          ref="finalReview"
            ></final-review>

            <div class="buttons">
                <button class="Button is-secondary" @click="goBackAStage">
                    Back
                </button>

                <button class="Button is-primary" :class="{'is-active': formActive}" @click="submit">
                    Submit
                </button>
            </div>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post';

    export default {
        props: [
            'meals',
            'initialItems',
            'locations'
        ],
        created: function() {
            let items = this.copy(this.initialItems);

            Object.keys(items).forEach(function(id) {
                items[id].amountInCupboard = 0;
            })

            this.items = items;
        },
        methods: {
            advanceStage() {
                this.selectedStage++;
            },
            goBackAStage() {
                this.selectedStage--;
            },
            submit() {
                if (this.formActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                let amounts = this.$refs['finalReview'].itemFinalAmounts;

                let items = [];

                Object.keys(amounts).forEach(function(id) {
                    items.push({
                        id: id,
                        amount: amounts[id]
                    });
                });

                data.append('items', JSON.stringify(items));

                console.log(JSON.stringify(items));

                this.formActive = true;
                this.post('/api/plans/store/', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/plans/');
                        return;
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            }
        },
        computed: {
            itemAmounts: function() {
                let amounts = {};

                Object.keys(this.items).forEach(function(key) {
                    amounts[key] = 0;
                });

                for (let i = 0; i < this.selectedMeals.length; i++) {
                    let selectedMeal = this.selectedMeals[i];

                    Object.keys(selectedMeal.items).forEach(function(key) {
                        let selectedItem = selectedMeal.items[key];

                        amounts[selectedItem.id] += selectedItem.amount;
                    });
                }

                return amounts;
            }
        },
        data: function() {
            return {
                selectedStage: 1,
                selectedMeals: [],
                items: {},
                formActive: false
            }
        },
        mixins: [Post]
    }

</script>
