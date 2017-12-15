import BrowserStorage from "../../classes/BrowserStorage"

let browserStorage = new BrowserStorage()

const state = {
    packages: [],

    summary: {},

    filterPackages: '',

    updating: false,
}

const getters = {
    homeGetFilteredRepositories(state) {
        const repositories = state.packages;

        if (state.filterPackages === '') {
            return repositories;
        }

        let result = []

        const words = state.filterPackages.split(' ')

        for (let key in repositories) {
            if (repositories.hasOwnProperty(key)) {
                let found = true

                for (const wordKey in words) {
                    const repository = repositories[key]

                    const s1 = repository.name.search(new RegExp(words[wordKey], "i")) !== -1

                    const s2 = repository.description.search(new RegExp(words[wordKey], "i")) !== -1

                    const s3 = repository.keywords.filter(function(keyword) {
                        return keyword.search(new RegExp(words[wordKey], "i")) !== -1
                    }).length > 0

                    console.log('found = found || s1 || s2 || s3', found , s1 , s2 , s3, words[wordKey]);

                    found = found && (s1 || s2 || s3)
                }

                if (found) {
                    result.push(repositories[key])
                }
            }
        }

        return result
    },
}

const actions = {
    homeLoadPackages(context, force) {
        context.commit('homeSetUpdating', true)

        force = typeof force !== 'undefined' ? '?force=true' : ''

        axios.get('/api/v1/packages'+force)
            .then(response => context.commit('homeSetPackages', response.data))
    },

    homeSaveToBrowserStorageAction(context) {
        browserStorage.put("appState", context.state.form)
    },

    homeLoadFromBrowserStorageAction(context) {
        const form = browserStorage.get("appState")

        context.commit("homeSetForm", form)
    },
}

const mutations = {
    homeSetPackages(state, data) {
        state.packages = data.packages

        state.summary = data.summary

        state.updating = false
    },

    homeSetFilterPackages(state, filterPackages) {
        state.filterPackages = filterPackages
    },

    homeAddToFilter(state, text) {
        text = state.filterPackages + ' ' + text

        state.filterPackages = text.trim().toLowerCase()
    },

    homeSetUpdating(state, value) {
        state.updating = value
    }
}

export default {
    state,
    getters,
    actions,
    mutations,
}
