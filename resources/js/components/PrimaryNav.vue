<template>
    <div class="PrimaryNav">
        <div class="bar">
            <svg xmlns="http://www.w3.org/2000/svg" class="hamburger" @click="toggleMobileNav">
                <use :xlink:href="'/images/icons.svg#menu'"></use>
            </svg>
            <a :href="headingLink" class="logo">
                <img src="/images/logo-2.svg" />
            </a>
        </div>

        <div class="mobile" :class="{'is-active': mobileNavActive}">
            <div class="header">

                <div class="top">
                    <form method="POST" action="/logout" v-if="authenticated">
                        <input type="hidden" name="_token" :value="csrftoken" />
                        <input type="submit" class="Button is-primary" value="Logout" />
                    </form>
                    <a href="/login" class="Button is-primary" v-else>Log In</a>

                    <svg xmlns="http://www.w3.org/2000/svg" @click="toggleMobileNav">
                        <use :xlink:href="'/images/icons.svg#close'"></use>
                    </svg>
                </div>

                <a href="/accounts/create/" class="sign-up Button is-secondary" v-if="!authenticated">
                    Create Account
                </a>

                <ul class="options" v-if="authenticated">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#home"></use>
                        </svg>
                        <a href="/home/items">Cupboard Items</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#heart"></use>
                        </svg>
                        <a href="/home/recipes">Recipes</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#home"></use>
                        </svg>
                        <a href="/home/collections">Collections</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#shopping-cart"></use>
                        </svg>
                        <a href="/home/plans">Saved Plans</a>
                    </li>
                </ul>

            </div>
            <div class="footer">
                <a href="/#">About MarbleTop</a>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: {
            'authenticated': {
                type: Boolean,
                default: false
            },
            'csrftoken': {
                type: String,
                default: ''
            }
        },
        methods: {
            toggleMobileNav: function() {
                this.mobileNavActive = !this.mobileNavActive;
            }
        },
        computed: {
            headingLink: function() {
                if (this.authenticated) {
                    return '/home';
                }
                return '/';
            }
        },
        data: function() {
            return {
                mobileNavActive: false
            }
        }
    }

</script>
