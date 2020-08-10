<template>
    <div class="ItemAmounts">
        <div class="amount" v-for="(item,key) in selectedItems">
            <label :for="'item-' + item.id">{{ item.name }}</label>
            <input type="text" :name="'item-' + item.id" value="" v-model="item.preciseAmount" />
            <svg xmlns="http://www.w3.org/2000/svg" @click="increaseOrder(item.order)">
                <use xlink:href="/images/icons.svg#chevron-up-outline"></use>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" @click="decreaseOrder(item.order)">
                <use xlink:href="/images/icons.svg#chevron-down-outline"></use>
            </svg>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'itemsData',
            'selectedItems'
        ],
        methods: {
            increaseOrder: function(position) {
                if (position === 0) {
                    return;
                }

                let targetEntryKey = this.selectedItems[position-1].key;
                let initialEntryKey = this.selectedItems[position].key;

                this.swapOrder({initialPosition: [targetEntryKey, position], targetPosition: [initialEntryKey, position-1]});
            },
            decreaseOrder: function(position) {
                if (position === this.selectedItems.length - 1) {
                    return;
                }

                let targetEntryKey = this.selectedItems[position+1].key;
                let initialEntryKey = this.selectedItems[position].key;

                this.swapOrder({initialPosition: [targetEntryKey, position], targetPosition: [initialEntryKey, position+1]});
            },
            swapOrder: function(positions) {
                this.itemsData[positions.targetPosition[0]].order = positions.targetPosition[1];
                this.itemsData[positions.initialPosition[0]].order = positions.initialPosition[1];
            }
        },
        data: function() {
            return {}
        }
    }

</script>
