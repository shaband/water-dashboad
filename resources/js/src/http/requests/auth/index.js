import axios from '@/http/axios/index'

export default {
    init () {
        axios.interceptors.response.use(function (response) {
            return response
        }, function (error) {
            return Promise.reject(error)
        })
    },
    login (credentials) {
        return axios.post('/admin/login', credentials)
    },
    logout () {
        return axios.post('/admin/logout')
    },
    me () {

        return axios('/admin/me')
    },

    forgetPassword (email) {

        return axios.post('/admin/forgot-password', {email})
    },
    resetPassword (credentials) {

        return axios.post('/admin/reset-password', credentials)
    }

}
