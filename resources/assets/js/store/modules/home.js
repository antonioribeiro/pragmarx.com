/**
 * Imports
 */
import BrowserStorage from "../../classes/BrowserStorage"
let browserStorage = new BrowserStorage()

/**
 * State
 */
const state = {
    data: {
        repositories: [],

        summary: {},

        filterRepositories: '',

        updating: false,

        showVendorModal: false,

        vendor: 'pragmarx',

        searchVendor: '',

        foundVendorRepositories: null,
    }
}

/**
 * Getters
 */
const getters = {
    homeGetFilteredRepositories(state) {
        const repositories = state.data.repositories

        if (state.data.filterRepositories === '') {
            return repositories
        }

        let result = []

        const words = state.data.filterRepositories.split(' ')

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

/**
 * Actions
 */
const actions = {
    homeLoadRepositories(context, force) {
        context.commit('homeSetUpdating', true)

        force = typeof force !== 'undefined' ? '?force=true' : ''

        axios.get('/api/v1/repositories/'+context.state.data.vendor+force)
            .then(response => context.commit('homeSetRepositories', response.data))
    },

    homeSearchVendorRepositoriesAction(context) {
        return axios.get('/api/v1/repositories/'+context.state.data.searchVendor)
            .then(response => context.commit('homeSetFoundVendorRepositories', response.data))
    },

    homeChangeVendorAction(context, vendor) {
        context.commit('homeSetRepositories', null)

        context.commit("homeSetVendor", vendor)

        context.commit("homeSetSearchVendor", '')

        context.dispatch('homeLoadRepositories')

        context.dispatch('homeSaveStateToStorageAction')
    },

    homeLoadStateFromStorageAction(context) {
        const state = browserStorage.get('homeState')

        if (state) {
            context.commit("homeSetState", state)
        }

        context.dispatch('homeLoadRepositories')
    },

    homeSaveStateToStorageAction(context) {
        browserStorage.put('homeState', context.state.data)
    },
}


/**
 * Mutations
 */
const mutations = {
    homeSetRepositories(state, data) {
        state.data.repositories = data

        state.data.updating = false
    },

    homeSetFilterRepositories(state, filterRepositories) {
        state.data.filterRepositories = filterRepositories
    },

    homeAddToFilter(state, text) {
        text = state.data.filterRepositories + ' ' + text

        state.data.filterRepositories = text.trim().toLowerCase()
    },

    homeSetUpdating(state, value) {
        state.data.updating = value
    },

    homeSetShowVendorModal(state, value) {
        console.log(state);
        state.data.showVendorModal = value
        console.log(state);
    },

    homeSetVendor(state, value) {
        state.data.vendor = value
    },

    homeSetSearchVendor(state, value) {
        state.data.searchVendor = value
    },

    homeSetFoundVendorRepositories(state, value) {
        state.data.foundVendorRepositories = value
    },

    homeSetState(context, value) {
        state.data = value
    },
}

/**
 * Exports
 */
export default {
    state,
    getters,
    actions,
    mutations,
}
