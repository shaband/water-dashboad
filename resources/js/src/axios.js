import axios from 'axios'
import i18n from '@/i18n/i18n'
import store from '@/store/store'
import router from 'vue-router'

const baseURL = '/api'
/*window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
*/
const instance = axios.create({baseURL})

instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
instance.interceptors.request.use(function (config) {

    config.headers.common['Content-Language'] = i18n.locale
    return config
}, function (error) {
    return Promise.reject(error)
})

instance.interceptors.response.use(
    response => {
        if ([200, 201, 204].includes(response.status)) {
            return Promise.resolve(response)
        } else {
            return Promise.reject(response)
        }
    },
    error => {
        if (error.response.status) {
            switch (error.response.status) {
                //400 Bad Request
            case 400:

                break
//401 Unauthorized
            case 401:
                store.commit('auth/removeAdmin')
                router.replace({
                    path: '/admin/login',

                })
                break
                //403 Forbidden
            case 403:
                // store.commit('logout')
                // router.replace({
                //     path: '/employee/login/',
                //     query: {redirect: router.currentRoute.fullPath}
                // })
                break
                //404 Not Found
            case 404:
                alert('page not exist')
                break
            case 422:
                break
            case 419:
                alert('page expired')

                window.location.reload()
                break

            default:
                debugger;
            }

            return Promise.reject(error.response)
        }
    }
)


export default instance
