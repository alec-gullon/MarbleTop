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
                    <label for="cooktime">How Long It Takes to Cook <span>(Optional)</span></label>
                    <select class="Select" id="cooktime" v-model="cookTime">
                        <option value="0">Please select..</option>
                        <option value="10">10 Mins</option>
                        <option value="20">20 Mins</option>
                        <option value="30">30 Mins</option>
                        <option value="45">45 Mins</option>
                        <option value="60">60 Mins</option>
                        <option value="90">90 Mins</option>
                        <option value="120">120 Mins</option>
                    </select>
                </div>

                <div class="InputWithLabel">
                    <label for="servingsize">How Many It Feeds <span>(Optional)</span></label>
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
                <h2>Ingredients</h2>
                <p>The list of things you want to include in the collection, along with an amount for each item</p>
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
            <button class="Button is-small is-primary" :class="{'is-disabled': !isFormReady, 'is-active': formActive}" @click="submit">
                Add Recipe
            </button>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';
    import Copy from './../../mixins/Copy.js';

    export default {
        data: function() {
            return {
                name: '',
                recipe: '',
                description: '',
                cookTime: 0,
                servingSize: 0,
                items: {},
                formActive: false,
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy],
        props: [
            '_items'
        ],
        created: function() {
            this.items = this.copy(this._items);
        },
        methods: {
            submit: function() {
                if (!this.isFormReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('recipe', this.recipe);
                data.append('description', this.description);
                data.append('serving_size', this.servingSize);
                data.append('cook_time', this.cookTime);
                data.append('image_id', Math.floor(Math.random() * 20) + 1);
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

                this.formActive = true;
                this.post('/api/recipes/store', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/recipes/');
                        return;
                    }

                    if (response.error) {
                        this.nameAlreadyExists = true;
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
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
        }
    }

</script>
