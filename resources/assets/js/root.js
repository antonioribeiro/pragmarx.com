import Vue from "vue"
import store from "./store/store.js"
import router from "./routes"

if (document.getElementById('vue-root')) {
    new Vue({
        el: "#vue-root",

        router,

        store,

        methods: {},

        computed: {},

        mounted() {
            // this.$store.commit("rootSetMounted", true)
            console.log('vue-root mounted');
        },
    })
} else {
    console.log('Application vue-root not found.')
}
