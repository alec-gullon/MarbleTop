<template>
    <div class="ItemsAdmin">
        <div class="AdminSection">

            <div class="label">
                <h2>Add Item</h2>
                <p>Add an item you might need to grab next time you go shopping: it could be anything,
                from tomatoes to cat food</p>
            </div>

            <div class="section">

                <item-creator :locations="locations"
                              :existingItems="existingItems"
                              v-on:itemAdded="updateItems"
                >
                </item-creator>

            </div>

        </div>

        <div class="AdminSection">
            <div class="label">
                <h2>Existing Items</h2>
                <p>The items that you currently track in the system</p>
            </div>

            <div class="section">
                <div class="ItemLocations">
                    <div class="location" v-for="id in locationsToDisplay">
                        <div class="header" @click="toggleLocationExpansion(id)">
                            <h3>{{ locations[id].name }}</h3>
                            <svg xmlns="http://www.w3.org/2000/svg">
                                <use xlink:href="/images/icons.svg#chevron-down" v-if="!locations[id].expanded"></use>
                                <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
                            </svg>
                        </div>

                        <div class="body" :class="{'is-expanded': locations[id].expanded}">
                            <item-editor v-for="itemId in locationItems[id].items"
                                         :key="'item-' + itemId"
                                         :item="items[itemId]"
                                         :existingItems="existingItems"
                                         v-on:itemUpdated="updateName"
                                         v-on:itemDeleted="updateItems"
                            ></item-editor>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Copy from './../../mixins/Copy';

    export default {
        props: [
            'initialItems',
            'initialLocations'
        ],
        created: function() {
            this.items = this.copy(this.initialItems);
            this.locations = this.copy(this.initialLocations);
        },
        methods: {
            updateName: function(data) {
                this.items[data.id].name = data.name;
            },
            updateItems: function(data) {
                this.items = data.items;
            },
            toggleLocationExpansion: function(id) {
                this.locations[id].expanded = !this.locations[id].expanded;
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
                items: {},
                locations: {}
            }
        },
        mixins: [Copy]
    }

</script>
