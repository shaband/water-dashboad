<template>
    <div id="chat-app" class="border border-solid d-theme-border-grey-light rounded relative overflow-hidden">
        <vs-sidebar class="items-no-padding" parent="#chat-app" :click-not-close="clickNotClose"
                    :hidden-background="clickNotClose" v-model="isChatSidebarActive" id="chat-list-sidebar">

            <!-- USER PROFILE SIDEBAR -->
            <!--
                        <user-profile :active="activeProfileSidebar" :userId="userProfileId" class="user-profile-container"
                                      :isLoggedInUser="isLoggedInUserProfileView"
                                      @closeProfileSidebar="closeProfileSidebar"></user-profile>
            -->

            <div class="chat__profile-search flex p-4">
                <div class="relative inline-flex">
                    <vs-avatar v-if="activeUser.image" class="m-0 border-2 border-solid border-white"
                               :src="activeUser.image" size="40px"
                    />
                    <!--         @click="showProfileSidebar(Number(activeUser.id), true)"           -->
                    <!--                    <div class="h-3 w-3 border-white border border-solid rounded-full absolute right-0 bottom-0"
                                             :class="'bg-' + getStatusColor(true)"></div>-->
                </div>

                <feather-icon class="md:inline-flex lg:hidden -ml-3 cursor-pointer" icon="XIcon"
                              @click="toggleChatSidebar(false)"/>
            </div>

            <vs-divider class="d-theme-border-grey-light m-0"/>
            <component :is="scrollbarTag" class="chat-scroll-area pt-4" :settings="settings" :key="$vs.rtl">

                <!-- ACTIVE CHATS LIST -->
                <div class="chat__chats-list mb-8">
                    <h3 class="text-primary mb-5 px-4">{{ $t('Chats') }}</h3>
                    <ul class="chat__active-chats bordered-items">
                        <li class="cursor-pointer" v-for="(chat, index) in chatContacts" :key="index"
                            @click="updateActiveChatUser(chat.other_user.id,chat.other_user.type)">
                            <chat-contact showLastMsg
                                          :contact=" chat.other_user"
                                          :lastMessaged="chat.last_message.time"
                                          :unseenMsg="0"

                            ></chat-contact>

                        </li>
                    </ul>
                </div>
                <!-- CONTACTS LIST -->
                <div class="chat__contacts">
                    <h3 class="text-primary mb-5 px-4">Contacts</h3>
                    <ul class="chat__contacts bordered-items">
                        <li class="cursor-pointer" v-for="contact in contacts" :key="contact.id"
                            @click="updateActiveChatUser(contact.id,'admins')">
                            <chat-contact :contact="contact"></chat-contact>
                        </li>
                    </ul>
                </div>
            </component>
        </vs-sidebar>

        <!-- RIGHT COLUMN -->
        <div
            class="chat__bg no-scroll-content chat-content-area border border-solid d-theme-border-grey-light border-t-0 border-r-0 border-b-0"
            :class="{'sidebar-spacer--wide': clickNotClose, 'flex items-center justify-center': activeChatUser === null}">
            <template v-if="activeChatUser">
                <div class="chat__navbar">
                    <chat-navbar :isSidebarCollapsed="!clickNotClose" :user-id="activeChatUser"
                                 :isPinnedProp="isChatPinned" @openContactsSidebar="toggleChatSidebar(true)"
                    ></chat-navbar>
                    <!--                    @showProfileSidebar="showProfileSidebar"
                                        @toggleIsChatPinned="toggleIsChatPinned"-->
                </div>
                <component :is="scrollbarTag"
                           class="chat-content-scroll-area border border-solid d-theme-border-grey-light"
                           :settings="settings" ref="chatLogPS" :key="$vs.rtl">
                    <div class="chat__log" ref="chatLog">
                        <chat-log :userId="activeChatUser" v-if="activeChatUser"></chat-log>
                    </div>
                </component>
                <div class="chat__input flex p-4 bg-white">
                    <vs-input class="flex-1" :placeholder="$t('Type Your Message')" v-model="typedMessage"
                              @keyup.enter="sendMsg"/>
                    <vs-button class="bg-primary-gradient ml-4" type="filled" @click="sendMsg">{{
                        $t('Send')
                        }}
                    </vs-button>
                </div>
            </template>
            <template v-else>
                <div class="flex flex-col items-center">
                    <feather-icon icon="MessageSquareIcon" class="mb-4 bg-white p-8 shadow-md rounded-full"
                                  svgClasses="w-16 h-16"></feather-icon>
                    <h4 class=" py-2 px-4 bg-white shadow-md rounded-full cursor-pointer"
                        @click.stop="toggleChatSidebar(true)">{{ $t('Start Conversation') }}</h4>
                </div>
            </template>
        </div>
    </div>
</template>
<!--<style src="vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css"/>-->

<script>
import ChatContact from './ChatContact.vue'
import ChatLog from './ChatLog.vue'
import ChatNavbar from './ChatNavbar.vue'
// import UserProfile from './UserProfile.vue'
// import VuePerfectScrollbar from 'vue-perfect-scrollbar'
import {PerfectScrollbar} from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'

import get from 'lodash/get'
// import moduleChat from '@/store/chat/moduleChat.js'

export default {
    data () {
        return {
            active: true,
            isHidden: false,
            searchContact: '',
            // activeProfileSidebar: false,
            activeChatUser: null,
            userProfileId: -1,
            typedMessage: '',
            isChatPinned: false,
            settings: {
                maxScrollbarLength: 60,
                wheelSpeed: 0.70
            },
            clickNotClose: true,
            isChatSidebarActive: true
            // isLoggedInUserProfileView: false
        }
    },
    watch: {
        windowWidth () {
            this.setSidebarWidth()
        }
    },
    computed: {
        chatLastMessaged () {
            return (chat) => this.$store.getters['chat/chatLastMessaged'](chat)
        },
        chatUnseenMessages () {
            return (chat) => {
                const unseenMsg = this.$store.getters['chat/chatUnseenMessages'](chat)
                if (unseenMsg) return unseenMsg
            }
        },
        activeUser () {
            return this.$store.getters['auth/getAdminInfo']
        },
        /*
                getStatusColor () {
                    return (isActiveUser) => {
                        const userStatus = this.getUserStatus(isActiveUser)

                        if (userStatus === 'online') {
                            return 'success'
                        } else if (userStatus === 'do not disturb') {
                            return 'danger'
                        } else if (userStatus === 'away') {
                            return 'warning'
                        } else {
                            return 'grey'
                        }
                    }
                },
        */
        chatContacts () {
            return this.$store.getters['chat/chatContacts']
        },
        contacts () {
            return this.$store.getters['chat/contacts']
        },

        scrollbarTag () {
            return this.$store.getters.scrollbarTag
        },
        /*   isActiveChatUser () {
               return (userId) => userId === this.activeChatUser
           },*/
        windowWidth () {
            return this.$store.state.windowWidth
        }
    },
    methods: {
        /*  getUserStatus (isActiveUser) {
              // return "active"
              return isActiveUser ? this.$store.state.AppActiveUser.status : this.contacts[this.activeChatUser].status
          },
        */  /*closeProfileSidebar (value) {
            this.activeProfileSidebar = value
        },*/
        updateActiveChatUser (contactId, contactType) {
            this.activeChatUser = contactId

            let
                params = {
                    model: contactType,
                    id: contactId
                }
            this.$store.dispatch('chat/fetchChatMessages', params)
            // if (this.$store.getters['chat/chatDataOfUser'](this.activeChatUser)) {
            //      this.$store.dispatch('chat/markSeenAllMessages', contactId)
            // }
            // const chatData = this.$store.getters['chat/chatDataOfUser'](this.activeChatUser)
            // if (chatData) this.isChatPinned = chatData.isPinned
            // else this.isChatPinned = false
            this.toggleChatSidebar()
            this.typedMessage = ''
        },
        /*showProfileSidebar (userId, openOnLeft = false) {
            this.userProfileId = userId
            this.isLoggedInUserProfileView = openOnLeft
            this.activeProfileSidebar = !this.activeProfileSidebar
        },*/
        sendMsg () {
            if (!this.typedMessage) return
            let current_chat = this.$store.getters['chat/chatDataOfUser']
            const payload = {
                'id': get(current_chat, 'id', null),
                'second_id': get(current_chat, 'other_user.id'),
                'second_type': get(current_chat, 'other_user.type', 'admins'),
                msg: {
                    'message': this.typedMessage
                }
            }

            this.$store.dispatch('chat/sendChatMessage', payload)
            this.typedMessage = ''

            const scroll_el = this.$refs.chatLogPS.$el || this.$refs.chatLogPS
            scroll_el.scrollTop = this.$refs.chatLog.scrollHeight
        },
        toggleIsChatPinned (value) {
            this.isChatPinned = value
        },
        setSidebarWidth () {
            if (this.windowWidth < 1200) {
                this.isChatSidebarActive = this.clickNotClose = false
            } else {
                this.isChatSidebarActive = this.clickNotClose = true
            }
        },
        toggleChatSidebar (value = false) {
            if (!value && this.clickNotClose) return
            this.isChatSidebarActive = value
        }
    },
    components: {
        // VuePerfectScrollbar,
        PerfectScrollbar,
        ChatContact,
        // UserProfile,
        ChatNavbar,
        ChatLog
    },
    async created () {
        // this.$store.registerModule('chat', moduleChat)
        this.$store.dispatch('chat/fetchContacts')
        this.$store.dispatch('chat/fetchChatContacts')
        // this.$store.dispatch('chat/fetchChats')
        this.setSidebarWidth()

        fcm.onMessage(function (payload) {
            debugger
        })
    },
    beforeDestroy () {
        // this.$store.unregisterModule('chat')
    },
    mounted () {
        // this.$store.dispatch('chat/setChatSearchQuery', '')
    }
}

</script>


<style lang="scss">
@import "@sass/vuexy/apps/chat.scss";
</style>
