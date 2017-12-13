export function rootSetMounted(state, mounted) {
    state.mounted = mounted
}

export function rootSetLocale(state, locale) {
    state.i18n.locale = locale ? locale : "en-US"
}
