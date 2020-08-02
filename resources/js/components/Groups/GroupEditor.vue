<template>
    <div class="MealEditor">

        <group-details :initialName="name"
                      :errored="detailsErrored"
                      v-on:update="updateDetails"
        ></group-details>

        <meal-ingredients :ingredientsData="ingredientsData"
                          :selectedIngredients="selectedIngredients"
        ></meal-ingredients>

        <div class="buttons">
            <button class="Button is-small" :class="{'is-disabled': !isFormReady, 'is-active': updateActive}" @click="update">
                Edit Group
            </button>

            <button class="Button is-alert is-small" :class="{'is-active': deleteActive}" @click="deleteGroup">
                Delete Group
            </button>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';
    import Errors from './../../mixins/Errors.js';

    export default {
        props: [
            'initialName',
            'initialIngredientsData',
            'groupId'
        ],
        created: function() {
            this.name = this.initialName;
            this.ingredientsData = this.initialIngredientsData;
        },
        methods: {
            updateDetails: function(event) {
                this.name = event.name;
                this.removeError('groupAlreadyExists');
            },
            update: function() {
                if (!this.isFormReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('api_token', document.global.apiToken);

                let ingredients = [];
                for (let i = 0; i < this.selectedIngredients.length; i++) {
                    let ingredient = this.selectedIngredients[i];
                    ingredients.push({
                        id: ingredient.id,
                        amount: ingredient.amount,
                    });
                }

                data.append('ingredients', JSON.stringify(ingredients));

                this.updateActive = true;
                this.post('/api/groups/' + this.groupId + '/update/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        window.location.replace('/home/groups/');
                        return;
                    }

                    if (response.error) {
                        this.errors.push(response.error);
                    }

                    this.updateActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            deleteGroup: function() {
                if (this.deleteActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.deleteActive = true;
                this.post('/api/groups/' + this.groupId + '/delete/', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/groups/');
                    }
                }.bind(this));
            }
        },
        computed: {
            isFormReady: function() {
                return (this.name !== '');
            },
            detailsErrored: function() {
                return this.checkForError('groupAlreadyExists');
            },
            selectedIngredients: function() {
                let ingredients = [];
                for (let i = 0; i < this.ingredientsData.length; i++) {
                    let ingredientData = this.ingredientsData[i];

                    if (ingredientData.selected) {
                        ingredients.push(ingredientData);
                    }
                }
                return ingredients;
            }
        },
        watch: {
            name: function() {
                this.removeError('groupAlreadyExists');
            }
        },
        data: function() {
            return {
                name: '',
                updateActive: false,
                deleteActive: false,
                errors: [],
                ingredientsData: []
            }
        },
        mixins: [Post, Errors]
    }

</script>
