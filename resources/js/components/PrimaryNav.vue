<template>
    <div class="PrimaryNav">
        <div class="bar">
            <div class="body">
                <svg xmlns="http://www.w3.org/2000/svg" class="hamburger" @click="toggleMobileNav">
                    <use :xlink:href="'/images/icons.svg#menu'"></use>
                </svg>
                <a :href="headingLink" class="logo">
                    <img src="/images/logo.svg" />
                </a>
                <ul class="links">
                    <li><a href="/accounts/create">How it Works</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/recipes">Recipes</a></li>

                    <li class="admin" v-if="authenticated" @click="toggleAdminLinks">
                        <div class="toggle">
                            <span>Your Kitchen</span>
                            <svg xmlns="http://www.w3.org/2000/svg">
                                <use :xlink:href="'/images/icons.svg#chevron-down'" v-if="!displayAdminLinks"></use>
                                <use :xlink:href="'/images/icons.svg#chevron-down'" v-else></use>
                            </svg>
                        </div>
                        <ul :class="{'is-enabled': displayAdminLinks}">
                            <li><a href="/home/plans">Plans</a></li>
                            <li><a href="/home/collections">Collections</a></li>
                            <li><a href="/home/recipes">Recipes</a></li>
                            <li><a href="/home/items">Items</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="/login" class="Button is-primary" v-if="!authenticated">
                    Log In
                </a>
                <form method="POST" action="/logout" v-if="authenticated">
                    <input type="hidden" name="_token" :value="csrftoken" />
                    <input type="submit" class="Button is-primary" value="Logout" />
                </form>
            </div>
        </div>

        <div class="mobile" :class="{'is-active': mobileNavActive}">
            <div class="header">

                <div class="close">
                    <svg xmlns="http://www.w3.org/2000/svg" @click="toggleMobileNav">
                        <use :xlink:href="'/images/icons.svg#close'"></use>
                    </svg>
                </div>

                <div class="top">
                    <form method="POST" action="/logout" v-if="authenticated">
                        <input type="hidden" name="_token" :value="csrftoken" />
                        <input type="submit" class="Button is-primary" value="Logout" />
                    </form>
                    <a href="/login" class="Button is-primary" v-else>Log In</a>

                    <a href="/accounts/create" class="sign-up Button is-secondary" v-if="!authenticated">
                        Create Account
                    </a>
                </div>



                <ul class="options" v-if="authenticated">
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#shopping-cart"></use>
                        </svg>
                        <a href="/home/plans">Plans</a>
                    </li>
                    <li>
                        <svg xmlns="http://www.w3.org/2000/svg">
                            <use xlink:href="/images/icons.svg#home"></use>
                        </svg>
                        <a href="/home/items">Items</a>
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

                </ul>

            </div>
            <div class="footer">
                <a href="/about">About MarbleTop</a>
                <a href="/recipes">Recipes</a>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function() {
            return {
                mobileNavActive: false,
                displayAdminLinks: false
            }
        },
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
            },
            toggleAdminLinks: function() {
                this.displayAdminLinks = !this.displayAdminLinks;
            }
        },
        computed: {
            headingLink: function() {
                if (this.authenticated) {
                    return '/home';
                }
                return '/';
            }
        }
    }

</script>
