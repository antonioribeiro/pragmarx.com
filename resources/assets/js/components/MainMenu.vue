<template>
    <div>
        <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow content-center">

                <div class="flex content-center">
                    <!--<div class="text-center p-2">-->
                        <!--<router-link to="/google2fa">-->
                            <!--Google2FA Test Page-->
                        <!--</router-link>-->
                    <!--</div>-->

                    <!--<div class="w-1/3 p-2">-->
                        <!--<div class="text-grey-darker text-center bg-grey-light p-2">1</div>-->
                    <!--</div>-->

                    <!--<span class="m-2 bold text-white">|</span>-->

                    <a href="https://github.com/antonioribeiro">
                        <i class="fab fa-github fa-3x"></i>
                    </a>

                    <!--<router-link to="/firewall">-->
                    <!--Firewall Test Page-->
                    <!--</router-link>-->

                    <!--&lt;!&ndash;class="{{ request()->is('firewall') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4"&ndash;&gt;-->

                    <!--&lt;!&ndash;class="{{ request()->is('google2fa') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4"&ndash;&gt;-->
                </div>


            </div>

            <!--<a-->
                <!--v-if="_laravel.user"-->
                <!--href="/google2fa/middleware/logout"-->
                <!--class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0"-->
            <!--&gt;-->
                <!--&lt;!&ndash;{{ $user->name }} ({{ $user->email }}) - logout&ndash;&gt;-->
            <!--</a>-->
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            _laravel() {
                return window.Laravel
            },
        },

        methods: {
            __loadPackages() {
                this.$store.dispatch('homeLoadPackages')
            },
        },

        mounted() {
            console.log('Component mounted.')

            this.__loadPackages()
        }
    }
</script>
