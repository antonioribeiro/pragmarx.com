<template>
    <div class="w-full md:w-1/2 xl:w-1/3 p-4">
        <div class="bg-white h-full flex flex-col p-4 justify-between leading-normal rounded overflow-hidden shadow border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light rounded-b lg:rounded-b-none lg:rounded-r">
            <div class="mb-2">
                <div class="flex mb-4">
                    <div
                        class="flex-1 font-bold text-xl cursor-pointer"
                        @click="__open(repository.github_url)"
                    >
                        <span class="text-black">
                            {{ repository.title }}
                        </span>

                        <span class="text-xs text-grey font-hairline">
                            {{ repository.version }}
                        </span>
                    </div>

                    <p
                        class="flex-1 text-sm text-grey-dark text-right cursor-pointer"
                        @click="__open(repository.github_only ? repository.github_url : repository.packagist_url)"
                    >
                        <span class="text-xs text-black font-hairline">
                            {{ repository.name }}
                        </span>
                    </p>
                </div>

                <div class="text-black mb-2">{{ repository.description }}</div>

                <div class="text-red mb-4">
                    <span v-for="keyword in __keywords(repository)" :key="keyword">
                        <badge :text="keyword"></badge>
                    </span>
                </div>
            </div>

            <div class="flex items-center">
                <div v-if="repository.downloads.total > -1" class="flex-1">
                    <p
                        class="text-blue leading-none cursor-pointer"
                        @click="__open(repository.packagist_url)"
                        title="Downloads"
                    >
                        <i class="fas fa-download" style="font-size: 1.5em;"></i> {{ __formatNumber(repository.downloads.total) }}
                    </p>
                </div>

                <div v-if="repository.website" class="flex-1">
                    <p
                        class="text-red leading-none cursor-pointer"
                        @click="__open(repository.website)"
                        title="Website"
                    >
                        <i class="fab fa-internet-explorer" style="font-size: 1.5em;"></i>
                    </p>
                </div>

                <div class="flex-1">
                    <p
                        class="text-blue text-right leading-none cursor-pointer"
                        @click="__open(repository.github_url)"
                        title="Github stars"
                    >
                        <i class="fab fa-github" style="font-size: 1.5em;"></i> {{ __formatNumber(repository.github_stars) }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['repository'],

        computed: {
        },

        methods: {
            __formatNumber(number) {
                return number.toLocaleString();
            },

            __keywords(repository) {
                return repository.keywords
            },

            __open(url) {
                window.open(url, '_blank');
            }
        },
    }
</script>

