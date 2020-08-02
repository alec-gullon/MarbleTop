<template>
    <div class="AdminPanel" :class="{'is-expanded': expanded}">
        <div class="header">
            <span>Ingredients</span>
            <svg xmlns="http://www.w3.org/2000/svg" @click="toggleExpanded">
                <use xlink:href="/images/icons.svg#chevron-down" v-if="!expanded"></use>
                <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
            </svg>
        </div>
        <div class="body">
            <div class="IngredientsEditor">

                <div class="search">
                    <div class="InputWithLabel">
                        <label for="new-ingredient">Search for Ingredient</label>
                        <input class="Input is-flat" id="new-ingredient" value="Cheese" v-model="searchTerm" />
                    </div>

                    <div class="results" v-if="filteredIngredients.length > 0">
                        <ul>
                            <li v-for="ingredient in filteredIngredients">
                                <span>{{ ingredient.name }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" @click="addIngredient(ingredient.key)">
                                    <use xlink:href="/images/icons.svg#add-outline"></use>
                                </svg>
                            </li>
                        </ul>
                    </div>
                </div>

                <ul v-if="selectedIngredients.length > 0">
                    <li v-for="ingredient in selectedIngredients">
                        <span class="name">{{ ingredient.name }}</span>
                        <div class="toggle">
                            <span @click="decrementAmount(ingredient.key)">‒</span>
                            <span class="amount">{{ ingredient.amount }}</span>
                            <span @click="incrementAmount(ingredient.key)">+</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" @click="removeIngredient(ingredient.key)">
                            <use xlink:href="/images/icons.svg#minus-outline"></use>
                        </svg>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'ingredientsData',
            'selectedIngredients'
        ],
        methods: {
            toggleExpanded: function() {
                this.expanded = !this.expanded;
            },
            addIngredient: function(key) {
                let order = this.selectedIngredients.length;

                this.ingredientsData[key].selected = true;
                this.ingredientsData[key].amount = 1;
                this.ingredientsData[key].order = order;
            },
            removeIngredient: function(key) {
                this.ingredientsData[key].selected = false;

                let order = this.ingredientsData[key].order;
                this.ingredientsData[key].order = -1;

                for (let i = order; i < this.selectedIngredients.length; i++) {
                    let key = this.selectedIngredients[i].key;
                    this.ingredientsData[key].order = this.ingredientsData[key].order-1;
                }

                this.searchTerm = '';
            },
            decrementAmount: function(key) {
                let currentAmount = this.ingredientsData[key].amount;

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

                this.ingredientsData[key].amount = amount;
            },
            incrementAmount: function(key) {
                let currentAmount = this.ingredientsData[key].amount;

                let amount = 0;
                if (currentAmount === 0) {
                    amount = 0.1;
                } else if (currentAmount === 0.1) {
                    amount = 0.25;
                } else {
                    amount = currentAmount + 0.25;
                }

                this.ingredientsData[key].amount = amount;
            }
        },
        computed: {
            filteredIngredients: function() {
                if (!this.searchTerm) {
                    return [];
                }

                let ingredients = [];
                for (let i = 0; i < this.ingredientsData.length; i++) {
                    let ingredientData = this.ingredientsData[i];

                    if (ingredientData.selected) {
                        continue;
                    }

                    if (ingredientData.name.includes(this.searchTerm)) {
                        ingredients.push(ingredientData);
                    }
                }
                return ingredients;
            }
        },
        data: function() {
            return {
                expanded: false,
                searchTerm: ''
            }
        }
    }

</script>
