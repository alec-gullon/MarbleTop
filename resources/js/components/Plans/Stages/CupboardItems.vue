<template>
    <div class="CupboardItems">
        <div class="IncrementRow" v-for="id in requiredItems">
            <div class="name">{{ items[id].name }}</div>
            <div class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="incrementAmountInCupboard(id)">
                    <use xlink:href="/images/icons.svg#minus-outline"></use>
                </svg>
                <span class="amount"
                      :class="{'is-alert': items[id].amountInCupboard > 0}"
                >
                    {{ parseFloat(parseFloat(itemAmounts[id] - items[id].amountInCupboard).toFixed(2)) }}
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="decrementAmountInCupboard(id)">
                    <use xlink:href="/images/icons.svg#add-outline"></use>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function() {
            return {}
        },
        props: [
            'items',
            'itemAmounts'
        ],
        methods: {
            decrementAmountInCupboard(id) {
                if (this.items[id].amountInCupboard === 0) {
                    return;
                }

                this.items[id].amountInCupboard -= 0.25;

                if (this.items[id].amountInCupboard < 0) {
                    this.items[id].amountInCupboard = 0;
                }
            },
            incrementAmountInCupboard(id) {
                if (this.items[id].amountInCupboard === this.itemAmounts[id]) {
                    return;
                }

                this.items[id].amountInCupboard += 0.25;

                if (this.items[id].amountInCupboard > this.itemAmounts[id]) {
                    this.items[id].amountInCupboard = this.itemAmounts[id];
                }
            },
        },
        computed: {
            requiredItems: function() {
                let items = [];

                Object.keys(this.itemAmounts).forEach(function(key) {
                    if (this.itemAmounts[key] > 0) {
                        items.push(key);
                    }
                }.bind(this));

                return items;
            }
        }
    }

</script>
