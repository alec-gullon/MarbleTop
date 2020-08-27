<template>
    <div class="RecipeCreator">

        <div class="AdminSection">
            <div class="label">
                <h2>Details</h2>
                <p>Edit the name of the collection</p>
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
            <button class="Button is-primary is-small" :class="{'is-disabled': !isFormReady, 'is-active': updateActive}" @click="update">
                Edit Collection
            </button>

            <button class="Button is-alert is-small" :class="{'is-active': deleteActive}" @click="deleteCollection">
                Delete Collection
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
            'initialItems',
            'collectionId'
        ],
        created: function() {
            this.name = this.initialName;
            this.items = this.copy(this.initialItems);
        },
        methods: {
            update: function() {
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
                        amount: item.amount,
                    });
                }

                data.append('items', JSON.stringify(items));

                this.updateActive = true;
                this.post('/api/collections/' + this.collectionId + '/update', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/collections');
                        return;
                    }

                    if (response.error) {
                        this.nameAlreadyExists = true;
                    }

                    this.updateActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            deleteCollection: function() {
                if (this.deleteActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.deleteActive = true;
                this.post('/api/collections/' + this.collectionId + '/destroy', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/collections');
                    }
                }.bind(this));
            }
        },
        computed: {
            isFormReady: function() {
                return (this.name !== '');
            },
            selectedItems: function() {
                let items = [];

                Object.keys(this.items).forEach(function(key) {
                    let item = this.items[key];

                    if (item.selected) {
                        items.push(item);
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
                updateActive: false,
                deleteActive: false,
                items: {},
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
