/**
 * Imports
 */
import Vue from "vue"
import VueRouter from "vue-router"

/**
 * Use VueRouter
 */
Vue.use(VueRouter)

/**
 * Views
 */
import Home from "./views/home.vue"
import Firewall from "./views/firewall.vue"

/**
 * Routes
 */
let routes = [
    { path: "/",         name: "home",     component: Home,     mustBeLoggedIn: false, },
    { path: "/firewall", name: "firewall", component: Firewall, mustBeLoggedIn: false, },
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
