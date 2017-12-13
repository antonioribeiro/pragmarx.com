import Vue from "vue"
import VueI18n from "vue-i18n"

Vue.use(VueI18n)

// Ready translated locale messages
import messages from "./messages"

// Create VueI18n instance with options
const i18n = new VueI18n({
    locale: "en-US", // set default locale

    messages, // set locale messages
})

export default i18n
