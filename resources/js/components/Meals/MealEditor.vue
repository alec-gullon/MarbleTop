<template>
    <div class="GroupCreator">
        <h2 class="heading">
            Details
        </h2>

        <div class="InputWithLabel" :class="{'is-error': nameAlreadyExists}">
            <label for="name">Name</label>
            <input class="Input" id="name" v-model="name" :class="{'is-error': nameAlreadyExists}" />
            <span class="error" v-if="nameAlreadyExists">Collection already exists</span>
        </div>

        <div class="InputWithLabel">
            <label for="recipe">Recipe</label>
            <textarea class="TextArea" id="recipe" v-model="recipe" />
        </div>

        <h2 class="heading">
            Items
        </h2>

        <item-searcher :itemsData="itemsData"
                       :selectedItems="selectedItems"
        ></item-searcher>

        <h2 class="heading">
            Amounts
        </h2>

        <item-amounts :itemsData="itemsData"
                      :selectedItems="selectedItems"
        >
        </item-amounts>

        <div class="buttons">
            <button class="Button is-small is-primary" :class="{'is-disabled': !isFormReady, 'is-active': updateActive}" @click="update">
                Edit Meal
            </button>

            <button class="Button is-alert is-small" :class="{'is-active': deleteActive}" @click="deleteMeal">
                Delete Meal
            </button>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';
    import Copy from './../../mixins/Copy.js';

    export default {
        props: [
            'initialName',
            'initialRecipe',
            'initialItemsData',
            'mealId'
        ],
        created: function() {
            this.name = this.initialName;
            this.recipe = this.initialRecipe;
            this.itemsData = this.copy(this.initialItemsData);
        },
        methods: {
            updateDetails: function(event) {
                this.name = event.name;
                this.recipe = event.recipe;
            },
            update: function() {
                if (!this.isFormReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('recipe', this.recipe);
                data.append('api_token', document.global.apiToken);

                let items = [];
                for (let i = 0; i < this.selectedItems.length; i++) {
                    let item = this.selectedItems[i];
                    items.push({
                        id: item.id,
                        amount: item.amount,
                        order: item.order,
                        preciseAmount: item.preciseAmount
                    });
                }

                data.append('items', JSON.stringify(items));

                this.updateActive = true;
                this.post('/api/meals/' + this.mealId + '/update/', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/meals/');
                        return;
                    }

                    if (response.error) {
                        this.nameAlreadyExists = true;
                    }

                    this.updateActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            deleteMeal: function() {
                if (this.deleteActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.deleteActive = true;
                this.post('/api/meals/' + this.mealId + '/destroy/', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/meals/');
                    }
                }.bind(this));
            }
        },
        computed: {
            isFormReady: function() {
                return (this.name !== '' && this.recipe !== '');
            },
            selectedItems: function() {
                let items = [];

                Object.keys(this.itemsData).forEach(function(key) {
                    let itemData = this.itemsData[key];

                    if (itemData.selected) {
                        items[itemData.order] = itemData;
                    }
                }.bind(this));

                return items;
            }
        },
        watch: {
            name: function() {
                this.nameAlreadyExists = false;
            }
        },
        data: function() {
            return {
                name: '',
                recipe: '',
                updateActive: false,
                deleteActive: false,
                itemsData: [],
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
