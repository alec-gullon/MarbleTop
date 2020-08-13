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
        props: [
            'initialItems'
        ],
        created: function() {
            this.items = this.copy(this.initialItems);
        },
        methods: {
            submit: function() {
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

                this.formActive = true;
                this.post('/api/recipes/store/', data, function(response) {
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
        },
        data: function() {
            return {
                name: '',
                recipe: '',
                items: {},
                formActive: false,
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
