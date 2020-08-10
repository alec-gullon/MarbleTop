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

        <h2 class="heading">
            Items
        </h2>

        <item-searcher  :itemsData="itemsData"
                        :selectedItems="selectedItems"
        ></item-searcher>

        <div class="buttons">
            <button class="Button is-primary is-small" :class="{'is-disabled': !isFormReady, 'is-active': updateActive}" @click="update">
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
    import Copy from './../../mixins/Copy.js';

    export default {
        props: [
            'initialName',
            'initialItemsData',
            'groupId'
        ],
        created: function() {
            this.name = this.initialName;
            this.itemsData = this.copy(this.initialItemsData);
        },
        methods: {
            updateDetails: function(event) {
                this.name = event.name;
            },
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
                this.post('/api/groups/' + this.groupId + '/update/', data, function(response) {
                    this.nameAlreadyExists = false;

                    if (response.status === 200) {
                        window.location.replace('/home/collections/');
                        return;
                    }

                    if (response.error) {
                        this.nameAlreadyExists = true;
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
                this.post('/api/groups/' + this.groupId + '/destroy/', data, function(response) {
                    if (response.status === 200) {
                        window.location.replace('/home/collections/');
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

                Object.keys(this.itemsData).forEach(function(key) {
                    let itemData = this.itemsData[key];

                    if (itemData.selected) {
                        items.push(itemData);
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
                itemsData: {},
                nameAlreadyExists: false
            }
        },
        mixins: [Post, Copy]
    }

</script>
