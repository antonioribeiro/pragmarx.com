<template>
    <div>
        <div class="text-center text-2xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-red-dark mb-8 font-black">
            <span v-if="_updating">
                <i class="text-blue-dark fas fa-cog fa-spin text-lg"></i>
            </span>

            We Forge Laravel Apps & PHP Packages

            <span v-if="_updating">
                <i class="text-blue-dark fas fa-cog fa-spin text-lg"></i>
            </span>
        </div>

        <!-- Five columns -->
        <div class="flex mb-4 mt-4 justify-center">
            <div class="flex-1 h-12"></div>
            <div class="flex justify-center bg-blue-dark">
                <div class="text-white text-center px-2 py-2 mt-4 mb-4 mr-8 ml-8" title="Repositories">
                    <p class="mb-4"><i class="fas fa-database fa-2x"></i></p>
                    <p>{{ _count }}</p>
                </div>

                <div class="text-white text-center px-2 py-2 mt-4 mb-4 mr-8 ml-8" title="Downloads">
                    <p class="mb-4"><i class="fas fa-download fa-2x"></i></p>
                    <p>{{ _downloads }}</p>
                </div>

                <div class="text-white text-center px-2 py-2 mt-4 mb-4 mr-8 ml-8" title="Github stars">
                    <p class="mb-4"><i class="fab fa-github fa-2x"></i></p>
                    <p>{{ _stars }}</p>
                </div>
            </div>
            <div class="flex-1 h-12"></div>
        </div>

        <div class="flex items-center flex-grow">
            <div class="flex-1 m-4 rounded overflow-hidden border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-blue-dark rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
                <p class="text-black">
                    <package-filter></package-filter>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap">
            <package-card v-for="repository in _repositories" :key="repository.name" :repository="repository"></package-card>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        mounted() {
            const timeout = 1000 * 60 * 10

            setTimeout(() => {
                setInterval(() => { this.__forceUpdate() }, timeout)
            }, timeout)
        },

        computed: {
            ...mapGetters({
                _repositories: 'homeGetFilteredRepositories',
            }),

            _updating() {
                return this.$store.state.home.updating
            },

            _downloads() {
                const repositories = this._repositories

                return Object.keys(repositories).reduce(function(previous, key) {
                    return previous + parseInt(repositories[key].downloads.total)
                }, 0).toLocaleString()
            },

            _stars() {
                const repositories = this._repositories

                return Object.keys(repositories).reduce(function(previous, key) {
                    return previous + parseInt(repositories[key].github_stars)
                }, 0).toLocaleString()
            },

            _count() {
                return Object.keys(this._repositories).length
            },
        },

        methods: {
            __forceUpdate() {
                return this.$store.dispatch('homeLoadPackages', true);
            },
        }
    }
</script>
