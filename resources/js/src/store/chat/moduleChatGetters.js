// import contacts from '@/views/apps/chat/contacts'
import get from 'lodash/get'

export default {
    chatDataOfUser: state => state.chat,
    chatMessages: (state, getters) => get(getters.chatDataOfUser, 'messages', []),
    chatContacts: (state, getters) => state.chatContacts,
    contacts: (state) => state.contacts,
    contact: (state) => contactId => state.contacts.find((contact) => contact.id === contactId),
    chats: (state) => state.chats,
    chatUser: (state, getters, rootState) => {
        return id => {

            return state.contacts.find((contact) => contact.id === id) || rootState.auth.admin
        }
    },

    chatLastMessaged: (state, getters) => chat => {
        return chat.last_message
    },
    chatUnseenMessages: (state, getters) => chat => {
        return chat.unseen_messages
    }
}
