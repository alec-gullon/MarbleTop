<template>
    <div class="PlanCreator">

        <div class="stage" v-if="selectedStage === 1">
            <h2><span class="number">1</span> Select your meals</h2>

            <table>
                <tbody>
                    <tr v-for="(meal,id) in meals">
                        <td>{{ meal.name }}</td>
                        <td>
                            <span @click="removeMeal(id)" class="Button">-</span>
                            <span>{{ mealAmounts[id] }}</span>
                            <span @click="addMeal(id)" class="Button">+</span>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button class="Button" @click="advanceStage">
                Next
            </button>
        </div>

        <div class="stage" v-if="selectedStage === 2">
            <h2><span class="number">2</span> Edit your selected meals</h2>

            <div v-for="meal in selectedMeals">
                <h3>{{ meals[meal.id].name }}</h3>
                <table>
                    <tr v-for="ingredient in meal.ingredients">
                        <td>{{ ingredients[ingredient.id].name }}</td>
                        <td>
                            <span class="Button" @click="decrementIngredient(ingredient)">-</span>

                            <span v-if="ingredient.amount < meals[meal.id].ingredients[ingredient.id].amount" style="color: red">
                                {{ ingredient.amount }}
                            </span>
                            <span v-else-if="ingredient.amount === meals[meal.id].ingredients[ingredient.id].amount">
                                {{ ingredient.amount }}
                            </span>
                            <span v-else style="color: green">
                                {{ ingredient.amount }}
                            </span>

                            <span class="Button" @click="incrementIngredient(ingredient)">+</span>
                        </td>
                    </tr>
                </table>
                <hr/>
            </div>

            <button class="Button" @click="goBackAStage">
                Back
            </button>

            <button class="Button" @click="advanceStage">
                Next
            </button>
        </div>

        <div class="stage" v-if="selectedStage === 3">
            <h2><span class="number">3</span> Deduct anything you already have</h2>

            <table>
                <tr v-for="id in requiredIngredients">
                    <td>{{ ingredients[id].name }}</td>
                    <td>
                        <span class="Button" @click="incrementAmountInCupboard(id)">-</span>

                        <span v-if="ingredients[id].amountInCupboard > 0" style="color: red">
                            {{ ingredientAmounts[id] - ingredients[id].amountInCupboard }}
                        </span>
                        <span v-else>
                            {{ ingredientAmounts[id] - ingredients[id].amountInCupboard }}
                        </span>

                        <span class="Button" @click="decrementAmountInCupboard(id)">+</span>
                    </td>
                </tr>
            </table>

            <button class="Button" @click="goBackAStage">
                Back
            </button>

            <button class="Button" @click="advanceStage">
                Next
            </button>

        </div>

        <div class="stage" v-if="selectedStage === 4">
            <h2><span class="number">4</span> Final review</h2>

            <table>
                <tr v-for="id in requiredIngredients">
                    <td>{{ ingredients[id].name }}</td>
                    <td>
                        {{ ingredientAmounts[id] }}
                    </td>
                </tr>
            </table>

            <button class="Button" @click="submit">
                Submit
            </button>
        </div>

    </div>
</template>

<script>

    export default {
        props: ['mealsData', 'ingredientsData'],
        created: function() {
            this.meals = JSON.parse(JSON.stringify(this.mealsData));

            let ingredients = JSON.parse(JSON.stringify(this.ingredientsData));

            Object.keys(ingredients).forEach(function(key) {
                ingredients[key].amountInCupboard = 0;
            })

            this.ingredients = ingredients;
        },
        methods: {
            removeMeal(id) {
                for (let i = this.selectedMeals.length - 1; 0 <= i; i--) {
                    if (this.selectedMeals[i].id === id) {
                        this.selectedMeals.splice(i, 1);
                        return;
                    }
                }
            },
            addMeal(id) {
                let ingredients = {}

                Object.keys(this.meals[id].ingredients).forEach(function(key) {
                    let ingredient = this.meals[id].ingredients[key];
                    ingredients[ingredient.id] = {
                        id: ingredient.id,
                        amount: ingredient.amount
                    }
                }.bind(this));

                let meal = {
                    'id': id,
                    'ingredients': ingredients
                };

                this.selectedMeals.push(meal);
            },
            decrementIngredient(ingredient) {
                ingredient.amount -= 0.25;
            },
            incrementIngredient(ingredient) {
                ingredient.amount += 0.25;
            },
            decrementAmountInCupboard(id) {
                this.ingredients[id].amountInCupboard -= 0.25;
            },
            incrementAmountInCupboard(id) {
                this.ingredients[id].amountInCupboard += 0.25;
            },
            advanceStage() {
                this.selectedStage++;
            },
            goBackAStage() {
                this.selectedStage--;
            },
            submit() {
                console.log('submitting');
            }
        },
        computed: {
            mealAmounts: function() {
                let amounts = {};

                Object.keys(this.meals).forEach(function(key) {
                     amounts[key] = 0;
                });

                for (let i = 0; i < this.selectedMeals.length; i++) {
                    amounts[this.selectedMeals[i].id]++;
                }

                return amounts;
            },
            ingredientAmounts: function() {
                let amounts = {};

                Object.keys(this.ingredients).forEach(function(key) {
                    amounts[key] = 0;
                });

                for (let i = 0; i < this.selectedMeals.length; i++) {
                    let selectedMeal = this.selectedMeals[i];

                    Object.keys(selectedMeal.ingredients).forEach(function(key) {
                        let selectedIngredient = selectedMeal.ingredients[key];

                        amounts[selectedIngredient.id] += selectedIngredient.amount;
                    });
                }

                return amounts;
            },
            requiredIngredients: function() {
                let ingredients = [];

                Object.keys(this.ingredientAmounts).forEach(function(key) {
                    if (this.ingredientAmounts[key] > 0) {
                        ingredients.push(key);
                    }
                }.bind(this));

                return ingredients;
            }
        },
        data: function() {
            return {
                selectedStage: 1,
                selectedMeals: [],
                meals: {},
                ingredients: {}
            }
        }
    }

</script>
