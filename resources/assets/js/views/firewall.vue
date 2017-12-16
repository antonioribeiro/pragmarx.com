<template>
    <div class="flex flex-col">
        <div class="text-center text-2xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-red-dark mb-8 font-black">
            <span v-if="_updating">
                <i class="text-blue-dark fas fa-cog fa-spin text-lg"></i>
            </span>

            We Forge Laravel Apps & PHP Repositories

            <span v-if="_updating">
                <i class="text-blue-dark fas fa-cog fa-spin text-lg"></i>
            </span>
        </div>

        <!--<iframe src="/firewall" width="100%" height="100%">-->
            <!--Your browser doesn't support iframes-->
        <!--</iframe>-->
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        mounted() {
        },

        computed: {
            ...mapGetters({
            }),
        },

        methods: {

        }
    }
</script>
