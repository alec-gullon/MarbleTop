<template>
    <div class="LoginForm"></div>
</template>

<script>

    export default {
        data: function() {
            return {
                email: 'guest@alecgullon.co.uk',
                password: 'password'
            }
        },
        computed: {
            formReady: function() {
                return (this.email !== '' && this.password !== '');
            }
        }
    }

</script>
