<template>
    <!-- @todo: Refactor this so it doesn't interact with parent data -->
    <div class="ItemSearcher">
        <div class="search">
            <label for="new-item" class="hidden">Search for Item</label>
            <input class="Input is-flat"
                   id="new-item"
                   v-model="searchTerm"
                   placeholder="Search for Item"
            />

            <div class="results" v-if="filteredItems.length > 0">
                <ul>
                    <li v-for="item in filteredItems">
                        <span>{{ item.name }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" @click="addItem(item.key)">
                            <use xlink:href="/images/icons.svg#add-outline"></use>
                        </svg>
                    </li>
                </ul>
            </div>
        </div>

        <ul v-if="selectedItems.length > 0">
            <li v-for="item in selectedItems" class="IncrementRow">
                <span class="name">{{ item.name }}</span>
                <div class="toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="decrementAmount(item.key)">
                        <use xlink:href="/images/icons.svg#minus-outline"></use>
                    </svg>
                    <span class="amount">{{ item.amount }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="incrementAmount(item.key)">
                        <use xlink:href="/images/icons.svg#add-outline"></use>
                    </svg>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="remove" @click="removeItem(item.key)">
                    <use xlink:href="/images/icons.svg#close-outline"></use>
                </svg>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: [
            'itemsData',
            'selectedItems'
        ],
        methods: {
            addItem: function(key) {
                let order = this.selectedItems.length;

                this.itemsData[key].selected = true;
                this.itemsData[key].amount = 1;
                this.itemsData[key].order = order;

                this.searchTerm = '';
            },
            removeItem: function(key) {
                this.itemsData[key].selected = false;

                let order = this.itemsData[key].order;
                this.itemsData[key].order = -1;

                for (let i = order; i < this.selectedItems.length; i++) {
                    let key = this.selectedItems[i].key;
                    this.itemsData[key].order = this.itemsData[key].order-1;
                }

                this.searchTerm = '';
            },
            decrementAmount: function(key) {
                let currentAmount = this.itemsData[key].amount;

                if (currentAmount === 0) {
                    return;
                }

                let amount = 0;
                if (currentAmount === 0.1) {
                    amount = 0;
                } else if (currentAmount === 0.25) {
                    amount = 0.1;
                } else {
                    amount = currentAmount - 0.25;
                }

                this.itemsData[key].amount = amount;
            },
            incrementAmount: function(key) {
                let currentAmount = this.itemsData[key].amount;

                let amount = 0;
                if (currentAmount === 0) {
                    amount = 0.1;
                } else if (currentAmount === 0.1) {
                    amount = 0.25;
                } else {
                    amount = currentAmount + 0.25;
                }

                this.itemsData[key].amount = amount;
            }
        },
        computed: {
            filteredItems: function() {
                if (!this.searchTerm) {
                    return [];
                }

                let items = [];

                Object.keys(this.itemsData).forEach(function(key) {
                    let itemData = this.itemsData[key];

                    if (itemData.selected) {
                        return;
                    }

                    if (itemData.name.includes(this.searchTerm)) {
                        items.push(itemData);
                    }
                }.bind(this));

                return items;
            }
        },
        data: function() {
            return {
                searchTerm: ''
            }
        }
    }

</script>
