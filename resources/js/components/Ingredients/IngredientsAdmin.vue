<template>
    <div class="IngredientsAdmin">
        <ingredient-creator :locations="locations"
                            :existingIngredients="existingIngredients"
                            @formSuccess="updateIngredients">
        </ingredient-creator>

        <div class="ingredients" v-if="ingredients.length > 0">
            <ingredient-editor v-for="(ingredient, key) in ingredients"
                               :key="ingredient.id"
                               :init="ingredient"
                               :locations="locations"
                               :existingIngredients="existingIngredients"
                               @formSuccess="updateIngredients"
            ></ingredient-editor>
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
