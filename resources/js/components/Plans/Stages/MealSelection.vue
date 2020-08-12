<template>
    <div class="MealSelection">
        <div class="IncrementRow" v-for="(meal,id) in meals">
            <div class="name">{{ meal.name }}</div>
            <div class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" class="decrement" @click="removeMeal(id)">
                    <use xlink:href="/images/icons.svg#minus-outline"></use>
                </svg>
                <span class="amount">{{ mealAmounts[id] }}</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="increment" @click="addMeal(id)">
                    <use xlink:href="/images/icons.svg#add-outline"></use>
                </svg>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'meals',
            'selectedMeals'
        ],
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
                let items = {}

                Object.keys(this.meals[id].items).forEach(function(key) {
                    let item = this.meals[id].items[key];
                    items[item.id] = {
                        id: item.id,
                        amount: item.amount,
                        originalAmount: item.amount
                    }
                }.bind(this));

                let meal = {
                    'id': id,
                    'items': items,
                    'expanded': false
                };

                this.selectedMeals.push(meal);
            },
        },
        computed: {
            mealAmounts: function() {
                let amounts = {};

                Object.keys(this.meals).forEach(function(id) {
                    amounts[id] = 0;
                });

                for (let i = 0; i < this.selectedMeals.length; i++) {
                    amounts[this.selectedMeals[i].id]++;
                }

                return amounts;
            }
        },
        data: function() {
            return {}
        }
    }

</script>
