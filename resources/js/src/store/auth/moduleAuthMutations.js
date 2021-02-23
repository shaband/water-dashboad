import ability from '@/services/ability'


export default {
    setAdmin (state, admin) {
        state.admin = admin

        localStorage.setItem('admin', JSON.stringify(admin))
        ability.update([{
            subject: 'all',
            action: admin.permissions
        }])
    },
    removeAdmin (state) {
        state.admin = null
        localStorage.removeItem('admin')
    },
    setFCM (state, fcm_messaging) {

        state.fcm = fcm_messaging
    },
    setToken (state, token) {
        state.fcm_token = token
        localStorage.setItem('admin_fcm_token', token)

    },
    removeToken (state) {
        state.fcm_token = null
        localStorage.removeItem('admin_fcm_token')

    }
}
