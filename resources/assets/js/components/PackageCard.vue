<template>
    <div class="w-1/3 max-w-sm m-4 rounded overflow-hidden shadow border-r border-b border-l border-grey-light lg:border-l-0 lg:border-t lg:border-grey-light bg-white rounded-b lg:rounded-b-none lg:rounded-r p-4 flex flex-col justify-between leading-normal">
        <div class="mb-2">
            <div class="flex mb-4">
                <div
                    class="flex-1 text-black font-bold text-xl cursor-pointer"
                    @click="__open(repository.github_url)"
                >
                    {{ repository.title }}
                </div>

                <p
                    class="flex-1 text-sm text-grey-dark text-right cursor-pointer"
                    @click="__open(repository.packagist_url)"
                >
                    {{ repository.name }}
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
            <div class="flex-1">
                <p
                    class="text-blue leading-none cursor-pointer"
                    @click="__open(repository.packagist_url)"
                >
                    <i class="fas fa-download" style="font-size: 1.5em;"></i> {{ __formatNumber(repository.downloads.total) }}
                </p>
            </div>

            <div class="flex-1">
                <p
                    class="text-blue text-right leading-none cursor-pointer"
                    @click="__open(repository.github_url)"
                >
                    <i class="fab fa-github" style="font-size: 1.5em;"></i> {{ __formatNumber(repository.github_stars) }}
                </p>
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
                return repository.versions['dev-master'].keywords
            },

            __open(url) {
                window.open(url, '_blank');
            }
        },
    }
</script>

