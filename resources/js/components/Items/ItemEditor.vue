<template>
    <div class="ItemEditor">
        <div class="FloatingInput">
            <div class="field" :class="{'is-active': formActive}">
                <input v-model="name" />
            </div>
            <div class="error" v-if="nameAlreadyExists">Item already exists</div>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" @click="update" :class="{'is-disabled': !formReady}">
            <use xlink:href="/images/icons.svg#checkmark-outline"></use>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" @click="destroy">
            <use xlink:href="/images/icons.svg#close-outline"></use>
        </svg>
    </div>
</template>

<script>

    import Post from './../../mixins/Post.js';

    export default {
        props: [
            'item',
            'existingItems'
        ],
        created: function() {
            this.name = this.item.name;
        },
        methods: {
            update: function() {
                if (!this.formReady || this.formActive) {
                    return;
                }

                let data = new FormData();
                data.append('name', this.name);
                data.append('location_id', this.item.locationId);
                data.append('api_token', document.global.apiToken);

                this.formActive = true;
                this.post('/api/items/' + this.item.id + '/update/', data, function(response) {
                    this.formError = (response.status !== 200);

                    if (response.status === 200) {
                        this.$emit('itemUpdated', {name: this.name, id: this.item.id});
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            },
            destroy: function() {
                if (!this.formReady || this.formActive) {
                    return;
                }

                let data = new FormData();
                data.append('api_token', document.global.apiToken);

                this.formActive = true;
                this.post('/api/items/' + this.item.id + '/destroy/', data, function(response) {
                    this.formError = (response.status !== 200);

                    if (response.status === 200) {
                        this.$emit('itemDeleted', {items: response.items});
                    }

                    this.formActive = false;
                    document.global.xhrActive = false;
                }.bind(this));
            }
        },
        computed: {
            formReady: function() {
                return (this.name !== '' && !this.nameAlreadyExists);
            },
            nameAlreadyExists: function() {
                return (this.name !== this.item.name && this.existingItems.indexOf(this.name) !== -1);
            }
        },
        data: function() {
            return {
                formActive: false,
                formError: false,
                name: ''
            }
        },
        mixins: [Post]
    }

</script>
