<template>
    <div class="ItemCreator" :class="{'is-expanded': expanded}">

        <div class="header" @click="toggleExpanded">
            <svg xmlns="http://www.w3.org/2000/svg">
                <use xlink:href="/images/icons.svg#plus-outline" v-if="!expanded"></use>
                <use xlink:href="/images/icons.svg#close-outline" v-else></use>
            </svg>
            Add Item
        </div>

        <div class="body">
            <div class="InputWithLabel">
                <label for="name">Name</label>
                <input class="Input" :class="{'is-error': checkForError('itemAlreadyExists')}" type="text" id="name" v-model="name" />
                <span class="error" v-if="checkForError('itemAlreadyExists')">An item with that name already exists.</span>
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
                Item successfully added!
            </div>

            <button class="Button is-small is-primary" :class="{'is-disabled': !formReady, 'is-active': formActive}" @click="submit">Add</button>
        </div>

    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';

    export default {
        props: [
            'locations',
            'existingItems'
        ],
        methods: {
            submit: function() {
                if (!this.formReady) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('location_id', this.locationId);
                data.append('api_token', document.global.apiToken);

                this.formActive = true;
                this.post('/api/items/store/', data, function(response) {
                    this.errors = [];

                    if (response.status === 200) {
                        this.name = '';
                        this.locationId = 0;

                        this.$emit('formSuccess', {items: response.items});

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
                let errorIndex = this.errors.indexOf('itemAlreadyExists');

                if (this.existingItems.indexOf(value) !== -1 && errorIndex === -1) {
                    this.errors.push('itemAlreadyExists');
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
