<template>
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
                        <svg xmlns="http://www.w3.org/2000/svg" @click="addItem(item.id)">
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
                    <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="decrementAmount(item.id)">
                        <use xlink:href="/images/icons.svg#minus-outline"></use>
                    </svg>
                    <span class="amount">{{ item.amount }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="incrementAmount(item.id)">
                        <use xlink:href="/images/icons.svg#add-outline"></use>
                    </svg>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="remove" @click="removeItem(item.id)">
                    <use xlink:href="/images/icons.svg#close-outline"></use>
                </svg>
            </li>
        </ul>
    </div>
</template>

<script>

    import Copy from './../../mixins/Copy';

    export default {
        props: [
            'initialItems',
            'selectedItems'
        ],
        created: function() {
            this.items = this.copy(this.initialItems);
        },
        methods: {
            addItem: function(id) {
                this.items[id].selected = true;
                this.items[id].amount = 1;
                this.items[id].order = this.selectedItems.length;

                this.$emit('itemUpdated', this.items);

                this.searchTerm = '';
            },
            removeItem: function(id) {
                this.items[id].selected = false;

                let order = this.items[id].order;
                this.items[id].order = -1;

                for (let i = order+1; i < this.selectedItems.length; i++) {
                    let id = this.selectedItems[i].id;
                    this.items[id].order = this.items[id].order-1;
                }

                this.$emit('itemRemoved', this.items);

                this.searchTerm = '';
            },
            decrementAmount: function(id) {
                let currentAmount = this.items[id].amount;

                if (currentAmount === 0) {
                    return;
                }

                let amount;
                if (currentAmount === 0.1) {
                    amount = 0;
                } else if (currentAmount === 0.25) {
                    amount = 0.1;
                } else {
                    amount = currentAmount - 0.25;
                }

                this.items[id].amount = amount;

                this.$emit('itemUpdated', this.items);
            },
            incrementAmount: function(id) {
                let currentAmount = this.items[id].amount;

                let amount;
                if (currentAmount === 0) {
                    amount = 0.1;
                } else if (currentAmount === 0.1) {
                    amount = 0.25;
                } else {
                    amount = currentAmount + 0.25;
                }

                this.items[id].amount = amount;

                this.$emit('itemUpdated', this.items);
            }
        },
        computed: {
            filteredItems: function() {
                if (!this.searchTerm) {
                    return [];
                }

                let items = [];

                Object.keys(this.items).forEach(function(key) {
                    let item = this.items[key];

                    if (item.selected) {
                        return;
                    }

                    if (item.name.includes(this.searchTerm)) {
                        items.push(item);
                    }
                }.bind(this));

                return items;
            }
        },
        data: function() {
            return {
                searchTerm: '',
                items: {}
            }
        },
        mixins: [Copy]
    }

</script>
