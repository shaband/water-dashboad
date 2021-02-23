import store from '@/store/store'
import get from 'lodash/get'
import ability from '@/services/ability'
import Vue from 'vue'

export const redirectIfGuest = async function (to, from, next) {
    store.dispatch('auth/getAuth').then((data) => {
            if (!store.getters['auth/isAdminAuthenticated']) {
                next({
                    name: 'admin.login',
                    query: {redirect: to.fullPath}
                })
            } else {

                next()
            }
        }
    )
}
export const redirectIfAdmin = function (to, from, next) {
    if (store.getters['auth/isAdminAuthenticated']) {
        next({
            name: 'admin.home'
            //     query: {redirect: to.fullPath}
        })
    } else {
        next()
    }
}

