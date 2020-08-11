<template>
    <div class="MealCreator">
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

        <item-searcher  :initialItems="items"
                        :selectedItems="selectedItems"
                        v-on:itemUpdated="updateItems"
                        v-on:itemRemoved="updateItems"
        ></item-searcher>

        <h2 class="heading">
            Amounts
        </h2>

        <item-amounts :items="items"
                      :selectedItems="selectedItems"
        >
        </item-amounts>

        <div class="buttons">
            <button class="Button is-small is-primary" :class="{'is-disabled': !isFormReady, 'is-active': formActive}" @click="submit">
                Add Meal
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
            updateItems: function(items) {
                this.items = items;
            },
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
                        preciseAmount: item.preciseAmount
                    });
                }

                data.append('items', JSON.stringify(items));

                this.formActive = true;
                this.post('/api/meals/store/', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/meals/');
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
                formActive: false,
                items: {},
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
