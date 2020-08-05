<template>
    <div class="IngredientsAdmin">
        <item-creator :locations="locations"
                      :existingItems="existingIngredients"
                      @formSuccess="updateIngredients">
        </item-creator>

<!--        <div class="ingredients" v-if="ingredients.length > 0">-->
<!--            <ingredient-editor v-for="(ingredient, key) in ingredients"-->
<!--                               :key="ingredient.id"-->
<!--                               :init="ingredient"-->
<!--                               :locations="locations"-->
<!--                               :existingIngredients="existingIngredients"-->
<!--                               @formSuccess="updateIngredients"-->
<!--            ></ingredient-editor>-->
<!--        </div>-->

        <div class="location">
            <h2>Fresh</h2>
            <div class="ingredient">
                <div class="field">
                    <input value="Cheese" class="is-active" />
                    <div class="active">
                        ...
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="/images/icons.svg#checkmark-outline"></use>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg">
                    <use xlink:href="/images/icons.svg#close-outline"></use>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'initIngredients',
            'locations'
        ],
        created: function() {
            this.ingredients = this.initIngredients;
        },
        methods: {
            updateIngredients: function(data) {
                this.ingredients = data.ingredients;
            }
        },
        computed: {
            existingIngredients: function() {
                let existingIngredients = [];
                for (let i = 0; i < this.ingredients.length; i++) {
                    existingIngredients.push(this.ingredients[i].name);
                }
                return existingIngredients;
            }
        },
        data: function() {
            return {
                ingredients: []
            }
        }
    }

</script>
