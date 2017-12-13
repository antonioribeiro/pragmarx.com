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

        let result = []

        for (let key in repositories) {
            if (repositories.hasOwnProperty(key)) {
                const repository = repositories[key]

                const s1 = repository.name.search(new RegExp(state.filterPackages, "i")) !== -1

                const s2 = repository.description.search(new RegExp(state.filterPackages, "i")) !== -1

                const s3 = repository.versions['dev-master'].keywords.filter(function(keyword) {
                    return keyword.search(new RegExp(state.filterPackages, "i")) !== -1
                }).length > 0

                if (s1 || s2 || s3) {
                    result.push(repository)
                }
            }
        }
        
        return result
    },
}

const actions = {
    homeLoadPackages(context) {
        context.commit('homeSetUpdating', true)

        axios.get('/api/v1/packages')
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
