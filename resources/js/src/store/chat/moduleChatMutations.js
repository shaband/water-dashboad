import Vue from 'vue'


export default {
    UPDATE_ABOUT_CHAT (state, obj) {
        obj.rootState.AppActiveUser.about = obj.value
    },
    UPDATE_STATUS_CHAT (state, obj) {
        obj.rootState.AppActiveUser.status = obj.value
    },

    SEND_CHAT_MESSAGE (state, message) {

        if (!!!state.chat.messages.find(({id}) => message.id === id)) {

            state.chat.messages.push(message)

        }
        if (state.chat.id === null) {
            state.chat.id = message.chat_id
        }
    },
    UPDATE_CONTACTS (state, contacts) {
        state.contacts = contacts
    },
    UPDATE_CHAT_CONTACTS (state, chatContacts) {
        state.chatContacts = chatContacts
    },
    UPDATE_CHATS (state, chats) {
        state.chats = chats
    },
    SET_CHAT_SEARCH_QUERY (state, query) {
        state.chatSearchQuery = query
    },
    MARK_SEEN_ALL_MESSAGES (state, payload) {
        payload.chatData.msg.forEach((msg) => {
            msg.isSeen = true
        })
    },
    FLUSH_CHAT (state) {
        state.chat = {
            id: null,
            other_user: {},
            messages: []

        }
    },
    SET_CHAT (state, chat) {
        state.chat = chat
    },
    TOGGLE_IS_PINNED (state, payload) {
        state.chats[Object.keys(state.chats).find(key => Number(key) === payload.id)].isPinned = payload.value
    }
}
