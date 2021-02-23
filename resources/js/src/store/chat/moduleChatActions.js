import admin from '@request/admins/admin'

import axios from '@/axios.js'
import chat from '@request/chats/chat'
import message from '@request/chats/message'

export default {
    setChatSearchQuery ({commit}, query) {
        commit('SET_CHAT_SEARCH_QUERY', query)
    },
    updateAboutChat ({
        commit,
        rootState
    }, value) {
        commit('UPDATE_ABOUT_CHAT', {
            rootState,
            value
        })
    },
    updateStatusChat ({
        commit,
        rootState
    }, value) {
        commit('UPDATE_STATUS_CHAT', {
            rootState,
            value
        })
    },

    // API CALLS
    sendChatMessage ({
        getters,
        commit,
        dispatch
    }, payload) {
        return new Promise((resolve, reject) => {
            chat.store(payload).then((response) => {
                dispatch('fetchChatContacts')
                let msg = response.data
                commit('SEND_CHAT_MESSAGE', msg)
                resolve(response)

            })

                .catch((error) => {
                    reject(error)
                })

        })
    },

    // Get contacts from server. Also change in store
    fetchContacts ({commit}) {


        return new Promise((resolve, reject) => {


            admin.every().then((response) => {
                commit('UPDATE_CONTACTS', response.data.data)
                resolve(response)
            })
                .catch((error) => {
                    reject(error)
                })

            // axios.get('/api/apps/chat/contacts', {params: {q: ''}})

        })
    },

    // Get chat-contacts from server. Also change in store
    fetchChatContacts ({commit}) {
        return new Promise((resolve, reject) => {
            chat.every().then(({
                data: {
                    data,
                    links,
                    meta
                }
            }) => {
                commit('UPDATE_CHAT_CONTACTS', data)
                resolve({
                    data,
                    links,
                    meta
                })

            }).catch((error) => {
                reject(error)
            })
            /*
            axios.get('/api/apps/chat/chat-contacts', {params: {q: ''}})
                .then((response) => {
                    commit('UPDATE_CHAT_CONTACTS', response.data)
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })*/
        })
    },

    // Get chats from server. Also change in store
    fetchChats ({commit}) {
        return new Promise((resolve, reject) => {
            axios.get('/api/apps/chat/chats')
                .then((response) => {
                    commit('UPDATE_CHATS', response.data)
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    },

    fetchChatMessages ({
        getters,
        commit
    }, params) {
        commit('FLUSH_CHAT')
        return new Promise((resolve, reject) => {
            chat.show(params.model, params.id).then((response) => {
                commit('SET_CHAT', response.data)
                resolve(response)
            })
                .catch((error) => {
                    reject(error)
                })
            /*   axios.post('/api/apps/chat/mark-all-seen', {id})
                   .then((response) => {
                       commit('MARK_SEEN_ALL_MESSAGES', {
                           id,
                           chatData: getters.chatDataOfUser(id)
                       })
                       resolve(response)
                   })*/

        })
    },

    toggleIsPinned ({commit}, payload) {
        return new Promise((resolve, reject) => {
            axios.post('/api/apps/chat/set-pinned/', {
                contactId: payload.id,
                value: payload.value
            })
                .then((response) => {
                    commit('TOGGLE_IS_PINNED', payload)
                    resolve(response)
                })
                .catch((error) => {
                    reject(error)
                })
        })
    }
}
