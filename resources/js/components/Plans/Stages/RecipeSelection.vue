<template>
    <div class="RecipeSelection">
        <div class="IncrementRow" v-for="(recipe,id) in recipes">
            <div class="name">{{ recipe.name }}</div>
            <div class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="removeRecipe(id)">
                    <use xlink:href="/images/icons.svg#minus-outline"></use>
                </svg>
                <span class="amount">{{ recipeAmounts[id] }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="addRecipe(id)">
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
            'recipes',
            'selectedRecipes'
        ],
        methods: {
            removeRecipe(id) {
                for (let i = this.selectedRecipes.length - 1; 0 <= i; i--) {
                    if (this.selectedRecipes[i].id === id) {
                        this.selectedRecipes.splice(i, 1);
                        return;
                    }
                }
            },
            addRecipe(id) {
                let items = {}

                Object.keys(this.recipes[id].items).forEach(function(key) {
                    let item = this.recipes[id].items[key];
                    items[item.id] = {
                        id: item.id,
                        amount: item.amount,
                        originalAmount: item.amount
                    }
                }.bind(this));

                let recipe = {
                    'id': id,
                    'items': items,
                    'expanded': false
                };

                this.selectedRecipes.push(recipe);
            },
        },
        computed: {
            recipeAmounts: function() {
                let amounts = {};

                Object.keys(this.recipes).forEach(function(id) {
                    amounts[id] = 0;
                });

                for (let i = 0; i < this.selectedRecipes.length; i++) {
                    amounts[this.selectedRecipes[i].id]++;
                }

                return amounts;
            }
        }
    }

</script>
