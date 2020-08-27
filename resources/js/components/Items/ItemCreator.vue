<template>

    <div class="ItemCreator">

        <div class="InputWithLabel">
            <label for="name">Name</label>
            <input class="Input" :class="{'is-error': nameAlreadyExists}" type="text" id="name" v-model="name" />
            <span class="error" v-if="nameAlreadyExists">An item with that name already exists.</span>
        </div>

        <div class="InputWithLabel">
            <label for="location">Supermarket Location</label>
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

        <button class="Button is-small is-primary"
                :class="{'is-disabled': !formReady, 'is-active': formActive}"
                @click="submit"
        >
            Add Item
        </button>

    </div>

</template>

<script>

    import Post from './../../mixins/Post.js';

    export default {
        mixins: [Post],
        data: function () {
            return {
                name: '',
                locationId: 0,
                reportSuccess: false,
                formActive: false,
            }
        },
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
                this.post('/api/items/store', data, function(response) {
                    if (response.status === 200) {
                        this.name = '';

                        this.$emit('itemAdded', {items: response.items});

                        this.reportSuccess = true;
                        setTimeout(function() {
                            this.reportSuccess = false;
                        }.bind(this), 3000);
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            }
        },
        computed: {
            formReady: function() {
                return (    this.name !== ''
                    &&      this.locationId !== 0
                    &&      !this.nameAlreadyExists);
            },
            nameAlreadyExists: function() {
                return (this.existingItems.indexOf(this.name) !== -1);
            }
        }
    }

</script>
