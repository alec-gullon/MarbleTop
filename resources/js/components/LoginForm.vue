<template>
    <div class="LoginForm"></div>
</template>

<script>

    export default {
        computed: {
            formReady: function() {
                return (this.email !== '' && this.password !== '');
            }
        },
        data: function() {
            return {
                email: 'guest@alecgullon.co.uk',
                password: 'password'
            }
        }
    }

</script>
