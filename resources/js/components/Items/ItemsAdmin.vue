<template>
    <!-- @todo: refactor these so the event-driven model doesn't pass around so much data -->
    <div class="ItemsAdmin">
        <item-creator :locations="locations"
                      :existingItems="existingItems"
                      v-on:itemAdded="updateItems"
        >
        </item-creator>

        <div class="location" v-for="id in locationsToDisplay">
            <h2>{{ locations[id].name }}</h2>

            <item-editor v-for="itemId in locationItems[id].items"
                         :key="'item-' + itemId"
                         :item="items[itemId]"
                         :existingItems="existingItems"
                         v-on:itemUpdated="updateName"
                         v-on:itemDeleted="updateItems"
            ></item-editor>
        </div>
    </div>
</template>

<script>

    import Copy from './../../mixins/Copy';

    export default {
        props: [
            'initialItems',
            'locations'
        ],
        created: function() {
            this.items = this.copy(this.initialItems);
        },
        methods: {
            updateName: function(data) {
                this.items[data.id].name = data.name;
            },
            updateItems: function(data) {
                this.items = data.items;
            }
        },
        computed: {
            existingItems: function() {
                let existingItems = [];

                Object.keys(this.items).forEach(function(key) {
                    existingItems.push(this.items[key].name);
                }.bind(this))

                return existingItems;
            },
            locationItems: function() {
                let locationItems = {};

                Object.keys(this.locations).forEach(function(key) {
                    locationItems[key] = {
                        items: [],
                        locationId: key
                    }
                }.bind(this));

                Object.keys(this.items).forEach(function(key) {
                    let item = this.items[key];
                    locationItems[item.locationId].items.push(item.id);
                }.bind(this));

                return locationItems;
            },
            locationsToDisplay: function() {
                let locations = [];

                Object.keys(this.locationItems).forEach(function(key) {
                    if (this.locationItems[key].items.length > 0) {
                        locations.push(key);
                    }
                }.bind(this));

                return locations;
            }
        },
        data: function() {
            return {
                items: {}
            }
        },
        mixins: [Copy]
    }

</script>