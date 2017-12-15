<template>
    <div>
        <div class="flex">
            <input
                class="flex-auto shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                placeholder="Looking for something?"
                v-model="_filterPackages"
            >

            <button
                v-if="_filterPackages"
                @click="__clearFilter()"
                class="flex-1 bg-red ml-2 hover:bg-red-dark text-white font-bold py-2 px-4 rounded"
                type="button"
            >
                <i class="fas fa-trash"></i>
            </button>
        </div>


    </div>
</template>

<script>
    export default {
        props: ['repository'],

        computed: {
            _filterPackages: {
                get() {
                    return this.$store.state.home.filterPackages
                },
                set(value) {
                    this.$store.commit('homeSetFilterPackages', value)
                }
            }
        },

        methods: {
            __formatNumber(number) {
                return number.toLocaleString()
            },

            __keywords(repository) {
                return repository.keywords
            },

            __clearFilter() {
                return this.$store.commit('homeSetFilterPackages', '')
            },
        },
    }
</script>

