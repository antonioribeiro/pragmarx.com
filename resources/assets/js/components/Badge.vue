<template>
    <button
        class="bg-blue hover:bg-blue-light text-white font-hairline text-xs hover:text-white py-1 px-2 border border-blue-dark hover:border-blue-darker rounded-full mr-2"
        @click="__addToFilter(text)"
    >
        {{ text.toLowerCase() }}
    </button>
</template>

<script>
    export default {
        props: ['text'],

        computed: {
        },

        methods: {
            __formatNumber(number) {
                return number.toLocaleString();
            },

            __keywords(repository) {
                return repository.keywords
            },

            __addToFilter(text) {
                this.$store.commit('homeAddToFilter', text);
            },
        },
    }
</script>
