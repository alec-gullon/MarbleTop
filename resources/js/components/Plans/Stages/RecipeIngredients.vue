<template>
    <div class="RecipeIngredients">
        <div v-for="recipe in selectedRecipes" class="recipe" :class="{'is-expanded': recipe.expanded}">
            <div class="header" @click="toggleRecipeExpansion(recipe)">
                <h3>{{ recipes[recipe.id].name }}</h3>
                <svg xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="/images/icons.svg#chevron-down" v-if="!recipe.expanded"></use>
                    <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
                </svg>
            </div>

            <div class="ingredients">
                <div class="IncrementRow" v-for="item in recipe.items">
                    <div class="name">{{ items[item.id].name }}</div>
                    <div class="toggle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="decrementItem(item)">
                            <use xlink:href="/images/icons.svg#minus-outline"></use>
                        </svg>
                        <span class="amount"
                              :class="{'is-alert': item.amount < item.originalAmount, 'is-success': item.amount > item.originalAmount}"
                        >
                                    {{ item.amount }}
                                </span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="incrementItem(item)">
                            <use xlink:href="/images/icons.svg#add-outline"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Amounts from './../../../mixins/Amounts';

    export default {
        mixins: [Amounts],
        data: function() {
            return {}
        },
        props: [
            'selectedRecipes',
            'recipes',
            'items'
        ],
        methods: {
            toggleRecipeExpansion(recipe) {
                recipe.expanded = !recipe.expanded;
            },
            decrementItem(item) {
                item.amount = this.decrementAmount(item.amount);
            },
            incrementItem(item) {
                item.amount = this.incrementAmount(item.amount);
            }
        }
    }

</script>
