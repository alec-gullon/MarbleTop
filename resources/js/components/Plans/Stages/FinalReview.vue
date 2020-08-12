<template>
    <div class="FinalReview">
        <div v-for="locationId in locationsToDisplay" class="location">
            <h3>{{ locations[locationId].name }}</h3>

            <div class="final-review">
                <div v-for="id in locationItems[locationId].items" class="ingredient">
                    <div class="name">{{ items[id].name }}</div>
                    <div class="amount">
                        {{ itemAmounts[id] - items[id].amountInCupboard }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'locations',
            'items',
            'itemAmounts'
        ],
        computed: {
            locationItems: function() {
                let locationItems = {};

                Object.keys(this.locations).forEach(function(key) {
                    locationItems[key] = {
                        items: [],
                        locationId: key
                    }
                }.bind(this));

                Object.keys(this.itemFinalAmounts).forEach(function(id) {
                    let item = this.items[id];
                    let amount = this.itemAmounts[id];

                    if (amount > 0) {
                        locationItems[item.locationId].items.push(id);
                    }
                }.bind(this));

                return locationItems;
            },
            itemFinalAmounts: function() {
                let amounts = this.copy(this.itemAmounts);

                Object.keys(amounts).forEach(function(id) {
                    amounts[id] = amounts[id] - this.items[id].amountInCupboard;

                    if (amounts[id] === 0) {
                        delete amounts[id];
                    }
                }.bind(this));

                return amounts;
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
            return {}
        }
    }

</script>
