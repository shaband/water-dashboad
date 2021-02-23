import Vue from 'vue'
import Vuex from 'vuex'
import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'
import moduleAuth from './auth/moduleAuth'
import moduleChat from '@/store/chat/moduleChat'

Vue.use(Vuex)

export default new Vuex.Store({
    getters,
    mutations,
    state,
    actions,
    modules: {
        'auth': moduleAuth,
         chat: moduleChat,

    },
    strict: process.env.NODE_ENV !== 'production'
})
