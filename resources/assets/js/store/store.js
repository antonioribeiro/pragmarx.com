/**
 * Imports
 */
import Vue from "vue"
import Vuex from "vuex"
import VueI18NLocalizationModule from "../localization/module.js"

/**
 * Vuex
 */
Vue.use(Vuex)

/**
 * Global state
 */
import * as actions from "./actions"
import * as getters from "./getters"
import * as mutations from "./mutations"

/**
 * Modules
 */
import home from "./modules/home"

/**
 * State
 */
const state = {
    mounted: false,

    environment: {
        debug: true,
    },

    i18n: VueI18NLocalizationModule,

    brand: "PragmaRX",
}

/**
 * Store
 */
export default new Vuex.Store({
    state,
    actions,
    getters,
    mutations,
    modules: {
        home,
    },
})
