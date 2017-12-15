<template>
    <div>
        <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
            <div class="text-sm lg:flex-grow">
                <a href="/firewall">
                    Firewall Test Page
                </a>

                <span class="m-2 bold text-white">|</span>
                <!--class="{{ request()->is('firewall') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4"-->

                <router-link to="/google2fa">
                    Google2FA Test Page
                </router-link>
                <!--class="{{ request()->is('google2fa') ? 'active' : '' }} block mt-4 lg:inline-block lg:mt-0 text-teal-lighter hover:text-white mr-4"-->
            </div>

            <a
                v-if="_laravel.user"
                href="/google2fa/middleware/logout"
                class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal hover:bg-white mt-4 lg:mt-0"
            >
                <!--{{ $user->name }} ({{ $user->email }}) - logout-->
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            _laravel() {
                return window.Laravel;
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
