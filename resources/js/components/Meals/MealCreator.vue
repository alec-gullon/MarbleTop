<template>
    <div class="MealEditor">

        <meal-details :initialName="name"
                      :initialRecipe="recipe"
                      :errored="detailsErrored"
                      v-on:update="updateDetails"
        ></meal-details>

        <meal-ingredients :ingredientsData="ingredientsData"
                          :selectedIngredients="selectedIngredients"
        ></meal-ingredients>

        <meal-amounts :ingredientsData="ingredientsData"
                      :selectedIngredients="selectedIngredients"
        >
        </meal-amounts>

        <button class="Button is-small" :class="{'is-disabled': !isFormReady, 'is-active': formActive}" @click="submit">
            Add Meal
        </button>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';
    import Errors from './../../mixins/Errors.js';

    export default {
        props: [
            'initialIngredientsData'
        ],
        created: function() {
            this.ingredientsData = this.initialIngredientsData;
        },
        methods: {
            updateDetails: function(event) {
                this.name = event.name;
                this.recipe = event.recipe;
            },
            submit: function() {
                if (!this.isFormReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('recipe', this.recipe);
                data.append('api_token', document.global.apiToken);

                let ingredients = [];
                for (let i = 0; i < this.selectedIngredients.length; i++) {
                    let ingredient = this.selectedIngredients[i];
                    ingredients.push({
                        id: ingredient.id,
                        amount: ingredient.amount,
                        order: ingredient.order,
                        preciseAmount: ingredient.preciseAmount
                    })

                }

                data.append('ingredients', JSON.stringify(ingredients));

                this.formActive = true;
                this.post('/api/meals/add/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        window.location.replace('/home/meals/');
                        return;
                    }

                    if (response.error) {
                        this.errors.push(response.error);
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
        },
        computed: {
            isFormReady: function() {
                return (this.name !== '' && this.recipe !== '');
            },
            detailsErrored: function() {
                return this.checkForError('mealAlreadyExists');
            },
            selectedIngredients: function() {
                let ingredients = [];
                for (let i = 0; i < this.ingredientsData.length; i++) {
                    let ingredientData = this.ingredientsData[i];

                    if (ingredientData.selected) {
                        ingredients[ingredientData.order] = ingredientData;
                    }
                }
                return ingredients;
            }
        },
        watch: {
            name: function() {
                this.removeError('mealAlreadyExists');
            }
        },
        data: function() {
            return {
                name: '',
                recipe: '',
                formActive: false,
                errors: [],
                ingredientsData: []
            }
        },
        mixins: [Post, Errors]
    }

</script>
