<template>
    <div class="RecipeCreator">
        <div class="details">
            <h2 class="AdminHeading">
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

            <button class="Button is-primary" :class="{'is-active': this.updateStatusActive}" @click="updatePublishStatus">
                <span v-if="this.published">Hide</span>
                <span v-else>Publish</span>
            </button>
        </div>

        <div class="items">
            <h2 class="AdminHeading">
                Items
            </h2>

            <item-searcher  :items="items"
                            :selectedItems="selectedItems"
            ></item-searcher>
        </div>

        <div class="amounts">
            <h2 class="AdminHeading">
                Amounts
            </h2>

            <item-amounts :items="items"
                          :selectedItems="selectedItems"
            >
            </item-amounts>
        </div>

        <div class="buttons">
            <button class="Button is-small is-primary" :class="{'is-disabled': !isFormReady, 'is-active': updateActive}" @click="update">
                Edit Recipe
            </button>

            <button class="Button is-alert is-small" :class="{'is-active': deleteActive}" @click="deleteRecipe">
                Delete Recipe
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
            'initialItems',
            'initialPublished',
            'recipeId'
        ],
        created: function() {
            this.name = this.initialName;
            this.recipe = this.initialRecipe;
            this.published = this.initialPublished;
            this.items = this.copy(this.initialItems);
        },
        methods: {
            updateItems: function(items) {
                this.items = items;
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
                        precise_amount: item.preciseAmount
                    });
                }

                data.append('items', JSON.stringify(items));

                this.updateActive = true;
                this.post('/api/recipes/' + this.recipeId + '/update', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/recipes');
                        return;
                    }

                    if (response.error) {
                        this.nameAlreadyExists = true;
                    }

                    this.updateActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            updatePublishStatus: function() {
                if (this.updateStatusActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.updateStatusActive = true;
                this.post('/api/recipes/' + this.recipeId + '/status/toggle' + status, data, function(response) {
                    if (response.status === 200) {
                        this.published = !this.published;

                        this.updateStatusActive = false;
                        document.global.xhrActive = false;
                    }
                }.bind(this));
            },
            deleteRecipe: function() {
                if (this.deleteActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.deleteActive = true;
                this.post('/api/recipes/' + this.recipeId + '/destroy', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/recipes');
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

                Object.keys(this.items).forEach(function(key) {
                    let item = this.items[key];

                    if (item.selected) {
                        items[item.order] = item;
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
                published: false,
                updateActive: false,
                deleteActive: false,
                updateStatusActive: false,
                items: {},
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
