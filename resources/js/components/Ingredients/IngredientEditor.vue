<template>
    <div class="IngredientEditor" :class="{'is-expanded': expanded}">
        <div class="header">
            {{ displayName }}
            <svg xmlns="http://www.w3.org/2000/svg" @click="toggleExpanded">
                <use xlink:href="/images/icons/chevron-down.svg#icon" v-if="!expanded"></use>
                <use xlink:href="/images/icons/chevron-up.svg#icon" v-else></use>
            </svg>
        </div>

        <div class="footer">
            <div class="footer-row">
                <div class="label">Name</div>
                <input class="Input"
                       :class="{'is-error': checkForError('ingredientAlreadyExists')}"
                       v-model="name"
                />
                <div class="error" v-if="checkForError('ingredientAlreadyExists')">
                    Ingredient Already Exists
                </div>
            </div>
            <div class="footer-row">
                <div class="label">Location</div>
                <select class="Select" v-model="locationId">
                    <option value="0">Please Select...</option>
                    <option v-for="location in locations" :value="location.id">
                        {{ location.name }}
                    </option>
                </select>
            </div>

            <div class="MessageBox is-success" v-if="reportSuccess">
                Ingredient successfully updated!
            </div>

            <div class="buttons">
                <div class="Button is-secondary is-small"
                     :class="{'is-disabled': !formReady, 'is-active': editActive}"
                     @click="edit"
                >
                    Update
                </div>

                <div class="Button is-alert is-small"
                     :class="{'is-active': removeActive}"
                    @click="remove"
                >
                    Delete
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';

    export default {
        props: [
            'init',
            'locations',
            'existingIngredients'
        ],
        created: function() {
            this.name = this.init.name;
            this.locationId = this.init.locationId;
            this.displayName = this.init.name;
        },
        methods: {
            edit: function() {
                if (!this.formReady || this.formActive) {
                    return;
                }

                this.editActive = true;

                let data = new FormData();
                data.append('name', this.name);
                data.append('locationId', this.locationId);
                data.append('ingredientId', this.init.id);
                data.append('respondWithIngredients', true);
                data.append('api_token', document.global.apiToken);

                this.post('/api/ingredients/update/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        this.$emit('formSuccess', {ingredients: response.ingredients});

                        this.displayName = this.name;

                        this.reportSuccess = true;
                        setTimeout(function() {
                            this.reportSuccess = false;
                        }.bind(this), 3000);
                    } else {
                        if (response.error) {
                            this.errors.push(response.error);
                        }
                    }

                    this.editActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            remove: function() {
                if (!this.formReady || this.formActive) {
                    return;
                }

                this.removeActive = true;

                let data = new FormData();
                data.append('ingredientId', this.init.id);
                data.append('respondWithIngredients', true);
                data.append('api_token', document.global.apiToken);

                this.post('/api/ingredients/remove/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        this.$emit('formSuccess', {ingredients: response.ingredients});
                    } else {
                        if (response.error) {
                            this.errors.push(response.error);
                        }
                    }

                    this.removeActive = false;
                }.bind(this));
            },
            toggleExpanded: function() {
                this.expanded = !this.expanded;
            },
            checkForError: function(key) {
                return (-1 !== this.errors.indexOf(key));
            }
        },
        watch: {
            name: function(value) {

                let errorIndex = this.errors.indexOf('ingredientAlreadyExists');

                if (this.init.name !== value && this.existingIngredients.indexOf(value) !== -1 && errorIndex === -1) {
                    this.errors.push('ingredientAlreadyExists');
                    return;
                }

                if (errorIndex !== -1) {
                    this.errors.splice(errorIndex, 1);
                }
            }
        },
        computed: {
            formReady: function() {
                return (    this.name !== ''
                    &&      this.locationId !== 0
                    &&      this.errors.length === 0);
            }
        },
        data: function() {
            return {
                errors: [],
                expanded: false,
                name: '',
                displayName: '',
                locationId: 0,
                editActive: false,
                removeActive: false,
                reportSuccess: false
            }
        },
        mixins: [Post]
    }

</script>
