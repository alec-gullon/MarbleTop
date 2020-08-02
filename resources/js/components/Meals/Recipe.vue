<template>
    <div class="Recipe">
        <div class="AdminPanel" :class="{'is-expanded': ingredientsExpanded}">
            <div class="header">
                <span>Ingredients</span>
                <svg xmlns="http://www.w3.org/2000/svg" @click="toggleIngredients">
                    <use xlink:href="/images/icons.svg#chevron-down" v-if="!ingredientsExpanded"></use>
                    <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
                </svg>
            </div>
            <div class="body">
                <table class="IngredientsTable">
                    <tbody>
                        <tr v-for="ingredient in ingredients">
                            <td><strong>{{ ingredient.name}}</strong></td>
                            <td>{{ ingredient.amount}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="AdminPanel" :class="{'is-expanded': recipeExpanded}">
            <div class="header">
                <span>Method</span>
                <svg xmlns="http://www.w3.org/2000/svg" @click="toggleRecipe">
                    <use xlink:href="/images/icons.svg#chevron-down" v-if="!recipeExpanded"></use>
                    <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
                </svg>
            </div>
            <div class="body">
                <div class="RecipeMethod" v-html="displayRecipe"></div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['recipe', 'ingredients'],
        methods: {
            toggleIngredients: function() {
                this.ingredientsExpanded = !this.ingredientsExpanded;
            },
            toggleRecipe: function() {
                this.recipeExpanded = !this.recipeExpanded;
            }
        },
        computed: {
            displayRecipe: function() {
                let parts = this.recipe.split(/\n\s*\n/);
                let recipe = parts.join('</p><p>');
                return '<p>' + recipe + '</p>';
            }
        },
        data: function() {
            return {
                ingredientsExpanded: false,
                recipeExpanded: false
            }
        }
    }

</script>
