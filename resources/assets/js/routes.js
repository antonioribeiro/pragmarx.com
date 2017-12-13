/**
 * Imports
 */
import Vue from "vue"
import VueRouter from "vue-router"
Vue.use(VueRouter)

/**
 * Views
 */
import Home from "./views/home.vue"

/**
 * Routes
 */
let routes = [
    {
        path: "/",
        name: "home",
        component: Home,
        mustBeLoggedIn: false,
    },
]

/**
 * Router
 */
let router = new VueRouter({
    routes,
    linkActiveClass: "nav-active",
})

/**
 * Exports
 */
export default router
