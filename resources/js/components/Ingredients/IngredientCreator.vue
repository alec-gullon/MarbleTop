<template>
    <div class="IngredientCreator" :class="{'is-expanded': expanded}">

        <div class="header">
            Add an Ingredient

            <svg xmlns="http://www.w3.org/2000/svg" @click="toggleExpanded">
                <use xlink:href="/images/icons/chevron-down.svg#icon" v-if="!expanded"></use>
                <use xlink:href="/images/icons/chevron-up.svg#icon" v-else></use>
            </svg>
        </div>

        <div class="footer">
            <div class="InputWithLabel">
                <label for="name">Name</label>
                <input class="Input" :class="{'is-error': checkForError('ingredientAlreadyExists')}" type="text" id="name" v-model="name" />
                <span class="error" v-if="checkForError('ingredientAlreadyExists')">An ingredient with that name already exists.</span>
            </div>

            <div class="InputWithLabel">
                <label for="location">Location</label>
                <select class="Select" id="location" v-model="locationId" >
                    <option value="0">Please Select...</option>
                    <option v-for="location in locations" :value="location.id">
                        {{ location.name }}
                    </option>
                </select>
            </div>

            <div class="MessageBox is-success" v-if="reportSuccess">
                Ingredient successfully added!
            </div>

            <button class="Button is-small" :class="{'is-disabled': !formReady, 'is-active': formActive}" @click="submit">Add</button>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';

    export default {
        props: [
            'locations',
            'existingIngredients'
        ],
        methods: {
            submit: function() {
                if (!this.formReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('locationId', this.locationId);
                data.append('respondWithIngredients', true);
                data.append('api_token', document.global.apiToken);

                this.formActive = true;
                this.post('/api/ingredients/add/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        this.name = '';
                        this.locationId = 0;

                        this.$emit('formSuccess', {ingredients: response.ingredients});

                        this.reportSuccess = true;
                        setTimeout(function() {
                            this.reportSuccess = false;
                        }.bind(this), 3000);
                    } else {
                        if (response.error) {
                            this.errors.push(response.error);
                        }
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            toggleExpanded: function() {
                this.expanded = !this.expanded;
            },
            checkForError: function(key) {
                return (-1 !== this.errors.indexOf(key));
            }
        },
        computed: {
            formReady: function() {
                return (    this.name !== ''
                    &&      this.locationId !== 0
                    &&      this.errors.length === 0);
            }
        },
        watch: {
            name: function(value) {
                let errorIndex = this.errors.indexOf('ingredientAlreadyExists');

                if (this.existingIngredients.indexOf(value) !== -1 && errorIndex === -1) {
                    this.errors.push('ingredientAlreadyExists');
                    return;
                }

                if (errorIndex !== -1) {
                    this.errors.splice(errorIndex, 1);
                }
            }
        },
        data: function () {
            return {
                expanded: false,
                errors: [],
                reportSuccess: false,
                formActive: false,
                name: '',
                locationId: 0
            }
        },
        mixins: [Post]
    }

</script>
