<template>
    <div class="AdminPanel" :class="{'is-expanded': expanded}">
        <div class="header">
            <span>Amounts</span>
            <svg xmlns="http://www.w3.org/2000/svg" @click="toggleExpanded">
                <use xlink:href="/images/icons.svg#chevron-down" v-if="!expanded"></use>
                <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
            </svg>
        </div>
        <div class="body">
            <div class="AmountsEditor">
                <div class="amount" v-for="(ingredient,key) in selectedIngredients">
                    <label :for="'ingredient-' + ingredient.id">{{ ingredient.name }}</label>
                    <input type="text" :name="'ingredient-' + ingredient.id" value="" v-model="ingredient.preciseAmount" />
                    <button class="ButtonIcon" @click="increaseOrder(ingredient.order)">
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#chevron-up"></use>
                        </svg>
                    </button>
                    <button class="ButtonIcon" @click="decreaseOrder(ingredient.order)">
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#chevron-down"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['ingredientsData', 'selectedIngredients'],
        methods: {
            toggleExpanded: function() {
                this.expanded = !this.expanded;
            },
            updateAmount: function(event) {
                console.log(event.value);

                // this.$emit('amountUpdated', {key: key, value: event.value});
            },
            increaseOrder: function(position) {
                if (position === 0) {
                    return;
                }

                let targetEntryKey = this.selectedIngredients[position-1].key;
                let initialEntryKey = this.selectedIngredients[position].key;

                this.swapOrder({initialPosition: [targetEntryKey, position], targetPosition: [initialEntryKey, position-1]});
            },
            decreaseOrder: function(position) {
                if (position === this.selectedIngredients.length - 1) {
                    return;
                }

                let targetEntryKey = this.selectedIngredients[position+1].key;
                let initialEntryKey = this.selectedIngredients[position].key;

                this.swapOrder({initialPosition: [targetEntryKey, position], targetPosition: [initialEntryKey, position+1]});
            },
            swapOrder: function(positions) {
                    this.ingredientsData[positions.targetPosition[0]].order = positions.targetPosition[1];
                    this.ingredientsData[positions.initialPosition[0]].order = positions.initialPosition[1];
            }
        },
        watch: {
            preciseAmounts: function() {
                this.$emit('amountsUpdated', {amounts: this.preciseAmounts});
            }
        },
        data: function() {
            return {
                expanded: false
            }
        }
    }

</script>
