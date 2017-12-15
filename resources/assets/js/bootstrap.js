/**
 * Bootstrap
 */

window._ = require('lodash')

/**
 * Vue
 */
window.Vue = require("vue")

/**
 * Vuex
 */
window.Vuex = require("vuex")

/**
 * jQuery
 */
window.$ = window.jQuery = require("jquery")

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = require("axios")

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */
let token = document.head.querySelector('meta[name="csrf-token"]')

window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
