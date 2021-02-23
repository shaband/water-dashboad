import Session from '@request/auth'
import router from '@/router/index'
import firebase from 'firebase'
import 'firebase/messaging'
import store from '@/store/store'
import fcm_token from '@request/fcm_tokens/fcm_token'

export default {
    async loginAttempt ({commit}, payload) {

        // await
        let credentials = {
            ...payload.credentials,
            'token': store.getters['auth/getFCMToken']
        }
        Session.login(credentials).then(({data}) => {
            // Vue.$vs.notify({
            //     title: this.$t('logged in Successfully')
            //     // color: 'danger'
            // })
            commit('setAdmin', data)
            payload.$router.push({
                name: 'admin.home'
            })

        }).catch((response) => {

                if (response.status === 422) {
                    payload.$vs.notify({
                        title: response.data.message
                        // color: 'danger'
                    })
                    payload.$refs.form.setErrors(response.data.errors)
                }
            }
        )

    },
    logoutAttempt ({
        commit,
        dispatch
    }, payload) {
        Session.logout().then((data) => {
            commit('removeAdmin')
            dispatch('revokeToken')
            payload.$router.push({
                name: 'admin.login'
            })

        }).catch((err) => {
                console.log(err)
            }
        )

    },
    async getAuth ({commit}, payload) {
        await Session.me().then(({data}) => {

            commit('setAdmin', data)

        }).catch((err) => {
                commit('removeAdmin')
                router.replace({
                    path: '/admin/login'
                    //query: {redirect: router.currentRoute.fullPath}
                })
            }
        )

    },
    async initFCM ({commit}) {
        await firebase.initializeApp({
            apiKey: process.env.MIX_FCM_KEY,
            authDomain: `${process.env.MIX_FCM_PROJECT_ID}.firebaseapp.com`,
            databaseURL: `https://${process.env.MIX_FCM_PROJECT_ID}.firebaseio.com`,
            projectId: process.env.MIX_FCM_PROJECT_ID,
            storageBucket: `${process.env.MIX_FCM_PROJECT_ID}.appspot.com`,
            messagingSenderId: process.env.MIX_FCM_SENDER_ID,
            appId: process.env.MIX_FCM_APP_ID,
            measurementId: process.env.MIX_FCM_MEASUREMENT_ID
        })
        const fcm_messaging = await firebase.messaging()
        await navigator.serviceWorker.register('/firebase-messaging-sw.js').then((registration) => {
            fcm_messaging.useServiceWorker(registration)
            commit('setFCM', fcm_messaging)
        })


    },

    async getToken ({
        commit,
        getters,
        dispatch,
        rootState,
        rootGetters
    }, payload) {

        await dispatch('initFCM')
        getters.getFCM.getToken(process.env.MIX_FCM_VOIP).then((token) => {
            if (getters.getFCMToken !== token && getters.isAdminAuthenticated) {
                //TODO::save new token to server
                fcm_token.store(payload, token).then((data) => {
                    //
                }).catch((err) => {
                    //
                })
            }
            commit('setToken', token)

        })
            .catch((e) => {
                commit('setToken', '')
                console.error(e)
            })

        getters.getFCM.onMessage((payload) => {

            let data = payload.data
            switch (data.type) {
            case 'new_chat_message':
                let new_message = {
                    ...data,
                    id: parseFloat(data.id),
                    chat_id: parseFloat(data.chat_id),
                    sender: {image: data.sender_image}
                }
                let chat = rootGetters['chat/chatDataOfUser']
                if (chat.id === parseFloat(new_message.chat_id)) {
                    commit('chat/SEND_CHAT_MESSAGE', new_message, {root: true})
                    dispatch('chat/fetchChatContacts', null, {root: true}
                    )
                }
                break
            default:
                break
            }
        })
        console.clear()

    },


    async revokeToken ({
        commit,
        getters
    }) {
        if (!!getters.getFCMToken) {
            await getters.getFCM.revokeToken()
            commit('removeToken')
        }

    },
    async initRefreshToken ({
        commit,
        getters,
        dispatch
    }, payload) {


        this.getters.getFCM.onTokenRefresh(function () {
            this.getters['auth/getFCM'].getToken()
                .then(function (refreshedToken) {
                    fcm_token.store('admin',{
                        token: refreshedToken,
                    })

                })
                .catch(function (err) {
                    console.log('Unable to retrieve refreshed token ', err)
                })
        })
    }
}
