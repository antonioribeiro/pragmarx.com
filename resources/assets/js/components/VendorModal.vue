<template>
    <div style="height: 500px"><!-- height set to show correctly on TailwindComponents not required when used -->
        <div class="fixed pin flex items-center">
            <div class="fixed pin bg-black opacity-75 z-10"></div>

            <div class="relative mx-6 md:mx-auto w-full md:w-1/2 lg:w-1/3 z-20 m-4">
                <div class="shadow-lg bg-white rounded-lg p-8">
                    <div class="flex justify-end mb-6">
                        <span @click="__closeModal()" class="cursor-pointer">
                            <i class="fa fa-times"></i>
                        </span>
                    </div>

                    <form class="">
                        <div class="mb-4 flex">
                            <div class="flex-1 flex flex-col">
                                <div class="flex-1">
                                    <input
                                        v-model="_vendor"
                                        @input="__vendorChange()"
                                        :readonly="searching"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                                        ref="vendor"
                                        type="text"
                                        placeholder="Vendor name"
                                    >
                                </div>

                                <div class="flex-1 font-hairline text-xs m-1 mt-2 text-black">
                                    <div v-if="!typing && !searching && _vendor && _repositoriesCount === 0" class="text-red">
                                        no repositories found
                                    </div>

                                    <div v-if="!typing && !searching && _vendor && _repositoriesCount > 0">
                                        {{ _repositoriesCount }} repositor{{ _repositoriesCount === 1 ? 'y' : 'ies' }} found for this vendor
                                    </div>

                                    <div v-if="typing">
                                        typing...
                                    </div>

                                    <div v-if="searching">
                                        searching...
                                    </div>
                                </div>
                            </div>

                            <div class="flex-initial">
                                <button
                                    @click.stop="__changeVendor(_vendor)"
                                    :class="
                                        (_repositoriesCount ? 'bg-red hover:bg-red-dark cursor-pointer text-white' : 'bg-grey-light text-grey') +
                                        ' flex-1 ml-2 font-hairline py-1 px-3 h-8 rounded shadow'
                                    "
                                >
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [],

        data() {
            return {
                vendorTypeTimeout: null,

                typing: false,

                searching: false,
            }
        },

        methods: {
            __closeModal() {
                this.$store.commit('homeSetShowVendorModal', false)
            },

            __vendorChange() {
                clearTimeout(this.vendorTypeTimeout)

                let me = this

                me.typing = true

                me.vendorTypeTimeout = setTimeout(function () {
                    me.typing = false

                    me.__searchVendorRepositories()
                }, 500);
            },

            __searchVendorRepositories() {
                const me = this

                me.searching = true

                me.$store
                    .dispatch('homeSearchVendorRepositoriesAction')
                    .then(() => { me.searching = false })
                    .catch(() => { me.searching = false })
            },

            __changeVendor(vendor) {
                this.__closeModal();

                this.$store.dispatch('homeChangeVendorAction', vendor)
            },
        },

        computed: {
            _repositoriesCount() {
                return this.$store.state.home.data.foundVendorRepositories
                    ? Object.keys(this.$store.state.home.data.foundVendorRepositories).length
                    : 0
            },

            _vendor: {
                get() {
                    return this.$store.state.home.data.searchVendor
                },
                set(searchVendor) {
                    return this.$store.commit('homeSetSearchVendor', searchVendor)
                }
            },
        },

        mounted() {
            this.$refs.vendor.focus()
        }
    }
</script>


