<template>
    <div class="RecipeCreator">

        <div class="AdminSection">

            <div class="label">
                <h2>Details</h2>
                <p>We need to know a few things about the recipe you're adding</p>
            </div>

            <div class="section">
                <div class="InputWithLabel" :class="{'is-error': nameAlreadyExists}">
                    <label for="name">Name</label>
                    <input class="Input" id="name" v-model="name" :class="{'is-error': nameAlreadyExists}" />
                    <span class="error" v-if="nameAlreadyExists">Collection already exists</span>
                </div>

                <div class="InputWithLabel">
                    <label for="recipe">Recipe</label>
                    <textarea class="TextArea" id="recipe" v-model="recipe" />
                </div>

                <div class="InputWithLabel">
                    <label for="description">Description <span>(Optional)</span></label>
                    <textarea class="TextArea" id="description" v-model="description" />
                </div>

                <div class="InputWithLabel">
                    <label for="cooktime">How Long it Takes to Cook <span>(Optional)</span></label>
                    <select class="Select" id="cooktime" v-model="cookTime">
                        <option :value="0">Please select..</option>
                        <option :value="10">10 Mins</option>
                        <option :value="20">20 Mins</option>
                        <option :value="30">30 Mins</option>
                        <option :value="45">45 Mins</option>
                        <option :value="60">60 Mins</option>
                        <option :value="90">90 Mins</option>
                        <option :value="120">120 Mins</option>
                    </select>
                </div>

                <div class="InputWithLabel">
                    <label for="servingsize">How Many it Feeds <span>(Optional)</span></label>
                    <select class="Select" id="servingsize" v-model="servingSize">
                        <option value="0">Please Select...</option>
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                    </select>
                </div>
            </div>

        </div>

        <div class="AdminSection">

            <div class="label">
                <h2>Publish Status</h2>
                <p>The current publish status of your recipe</p>
            </div>

            <div class="section">
                <p v-if="published">Currently published.</p>
                <p v-else>Currently unpublished.</p>

                <p v-if="!publishable">
                    In order to publish a recipe, you must set the <strong>Description</strong>,
                    <strong>How Long it Takes to Cook</strong> and <strong>How Many it Feeds</strong> fields.
                </p>
                <button v-else class="Button is-primary is-small" :class="{'is-active': this.updateStatusActive}" @click="updatePublishStatus">
                    <span v-if="this.published">Unpublish</span>
                    <span v-else>Publish</span>
                </button>
            </div>

        </div>

        <div class="AdminSection">

            <div class="label">
                <h2>Ingredients</h2>
                <p>The list of ingredients you want to include in the recipe, along with an amount for each ingredient</p>
            </div>

            <div class="section">
                <item-searcher  :items="items"
                                :selectedItems="selectedItems"
                ></item-searcher>
            </div>

        </div>

        <div class="AdminSection">

            <div class="label">
                <h2>Amounts</h2>
                <p>The precise amount of each ingredient in the recipe: a tsp of this, 100g of that, 2 of those. Leave
                    blank if you don't want to specify a precise amount. You can also customise the display order in this
                    section</p>
            </div>

            <div class="section">
                <item-amounts :items="items"
                              :selectedItems="selectedItems"
                >
                </item-amounts>
            </div>

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
        mixins: [Post, Copy],
        data: function() {
            return {
                name: '',
                recipe: '',
                description: '',
                cookTime: 0,
                servingSize: 0,
                published: false,
                updateActive: false,
                deleteActive: false,
                updateStatusActive: false,
                items: {},
                nameAlreadyExists: false
            }
        },
        props: [
            '_name',
            '_recipe',
            '_description',
            '_cookTime',
            '_servingSize',
            '_items',
            '_published',
            'recipeId'
        ],
        created: function() {
            this.name = this._name;
            this.recipe = this._recipe;
            this.description = this._description;
            this.cookTime = this._cookTime;
            this.servingSize = this._servingSize;
            this.published = this._published;
            this.items = this.copy(this._items);
        },
        methods: {
            update: function() {
                if (!this.isFormReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('recipe', this.recipe);
                data.append('description', this.description);
                data.append('serving_size', this.servingSize);
                data.append('cook_time', this.cookTime);
                data.append('api_token', document.global.apiToken);

                let items = [];
                for (let i = 0; i < this.selectedItems.length; i++) {
                    let item = this.selectedItems[i];
                    console.log(item);
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
            },
            publishable: function() {
                if (this._description && this._servingSize !== 0 && this._cookTime !== 0) {
                    return true;
                }
                return false;
            }
        },
        watch: {
            name: function() {
                this.nameAlreadyExists = false;
            }
        }
    }

</script>
