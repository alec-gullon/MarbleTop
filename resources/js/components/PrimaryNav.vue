<template>
    <div class="PrimaryNav">
        <div class="bar">
            <svg xmlns="http://www.w3.org/2000/svg" class="hamburger" @click="toggleMobileNav">
                <use :xlink:href="'/images/icons.svg#menu'"></use>
            </svg>
            <a href="/" class="logo">
                <img src="/images/logo.svg" />
            </a>
        </div>

        <div class="mobile" :class="{'is-active': mobileNavActive}">
            <div class="header">

                <div class="top">
                    <form method="POST" action="/logout" v-if="authenticated">
                        <input type="hidden" name="_token" :value="csrftoken" />
                        <input type="submit" class="Button" value="Logout" />
                    </form>
                    <a href="/login" class="Button" v-else>Log In</a>

                    <svg xmlns="http://www.w3.org/2000/svg" @click="toggleMobileNav">
                        <use :xlink:href="'/images/icons.svg#close'"></use>
                    </svg>
                </div>

                <ul class="options">
                    <li>
                        <img src="/images/icons/document.svg" /><a href="/home/ingredients">Ingredients</a>
                    </li>
                    <li>
                        <img src="/images/icons/document.svg" /><a href="/home/meals">Meals</a>
                    </li>
                    <li>
                        <img src="/images/icons/document.svg" /><a href="/home/groups">Groups</a>
                    </li>
                    <li>
                        <img src="/images/icons/document.svg" /><a href="/home/plans">Saved Plans</a>
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
        data: function() {
            return {
                mobileNavActive: false
            }
        }
    }

</script>
