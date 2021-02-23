export default {

    getAdminInfo (state) {

        return state.admin || null
    },
    isAdminAuthenticated (state, getters) {
        return !!getters.getAdminInfo
    },
    getFCMToken (state) {
        return state.fcm_token
    },
    getFCM (state) {
        return state.fcm
    },
}
