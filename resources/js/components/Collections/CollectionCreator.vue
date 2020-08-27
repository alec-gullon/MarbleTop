<template>
    <div class="RecipeCreator">
        <div class="AdminSection">

            <div class="label">
                <h2>Details</h2>
                <p>Start with a name</p>
            </div>

            <div class="section">
                <div class="InputWithLabel" :class="{'is-error': nameAlreadyExists}">
                    <label for="name">Name</label>
                    <input class="Input" id="name" v-model="name" :class="{'is-error': nameAlreadyExists}" />
                    <span class="error" v-if="nameAlreadyExists">Collection already exists</span>
                </div>
            </div>

        </div>

        <div class="AdminSection">

            <div class="label">
                <h2>Items</h2>
                <p>The list of things you want to include in the collection, along with an amount for each item</p>
            </div>

            <div class="section">
                <item-searcher  :items="items"
                                :selectedItems="selectedItems"
                ></item-searcher>
            </div>

        </div>

        <div class="buttons">
            <button class="Button is-primary is-small" :class="{'is-disabled': !isFormReady, 'is-active': formActive}" @click="submit">
                Add Collection
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
                data.append('api_token', document.global.apiToken);

                let items = [];
                for (let i = 0; i < this.selectedItems.length; i++) {
                    let item = this.selectedItems[i];
                    items.push({
                        id: item.id,
                        amount: item.amount
                    });
                }

                data.append('items', JSON.stringify(items));

                this.formActive = true;
                this.post('/api/collections/store', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/collections');
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
                return (this.name !== '');
            },
            selectedItems: function() {
                let items = [];

                Object.keys(this.items).forEach(function(key) {
                    let itemData = this.items[key];

                    if (itemData.selected) {
                        items[itemData.order] = itemData;
                    }
                }.bind(this));

                return items;
            }
        },
        data: function() {
            return {
                name: '',
                formActive: false,
                nameAlreadyExists: false,
                items: {}
            }
        },
        mixins: [Post, Copy]
    }

</script>
