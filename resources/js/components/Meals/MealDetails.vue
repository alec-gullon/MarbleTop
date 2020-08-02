<template>
    <div class="AdminPanel" :class="{'is-expanded': expanded}">
        <div class="header" :class="{'is-error': errored}">
            <span>Details</span>
            <svg xmlns="http://www.w3.org/2000/svg" @click="toggleExpanded">
                <use xlink:href="/images/icons.svg#chevron-down" v-if="!expanded"></use>
                <use xlink:href="/images/icons.svg#chevron-up" v-else></use>
            </svg>
        </div>
        <div class="body">
            <div class="MealDetails">
                <div class="InputWithLabel">
                    <label for="name">Name</label>
                    <input class="Input" id="name" v-model="name" :class="{'is-error': errored}"/>
                    <span class="error" v-if="errored">A meal with that name already exists</span>
                </div>

                <div class="recipe InputWithLabel">
                    <label for="recipe">Recipe</label>
                    <textarea class="TextArea" id="recipe" v-model="recipe"></textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [
            'initialRecipe',
            'initialName',
            'errored'
        ],
        created: function() {
            this.name = this.initialName;
            this.recipe = this.initialRecipe;
        },
        methods: {
            toggleExpanded: function() {
                this.expanded = !this.expanded;
            },
            emitUpdate: function() {
                this.$emit('update', {name: this.name, recipe: this.recipe});
            }
        },
        watch: {
            name: function() {
                this.emitUpdate();
            },
            recipe: function() {
                this.emitUpdate();
            }
        },
        data: function() {
            return {
                name: '',
                recipe: '',
                expanded: false
            }
        }
    }

</script>
