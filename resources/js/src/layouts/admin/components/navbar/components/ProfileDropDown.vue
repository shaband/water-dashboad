<template>
    <div class="the-navbar__user-meta flex items-center" v-if="activeUserInfo.name">

        <div class="text-right leading-tight hidden sm:block">
            <p class="font-semibold">{{ activeUserInfo| get('name') }}</p>
            <small>{{ $t('Available') }}</small>
        </div>

        <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">

            <div class="con-img ml-3">
                <img key="onlineImg"
                     src="https://i.picsum.photos/id/675/200/300.jpg?hmac=c2gHO4_1hIFBRijtOhz09icBTxsdGCsMSYSs2XIDdAk"
                     alt="user-img"
                     width="40" height="40" class="rounded-full shadow-md cursor-pointer block"/>
            </div>

            <vs-dropdown-menu class="vx-navbar-dropdown">
                <ul style="min-width: 9rem">

                    <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push({
                    name:`admin.admins.profile`,
                    params:{id:activeUserInfo.id}
                    })">
                        <feather-icon icon="UserIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">{{ $t('Profile') }}</span>
                    </li>
                    <!--

                              <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                                <feather-icon icon="MailIcon" svgClasses="w-4 h-4" />
                                <span class="ml-2">Inbox</span>
                              </li>

                              <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                                <feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4" />
                                <span class="ml-2">Tasks</span>
                              </li>
                    -->

                    <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                        <feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">{{ $t('Chat') }}</span>
                    </li>
                    <!--

                              <li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white">
                                <feather-icon icon="HeartIcon" svgClasses="w-4 h-4" />
                                <span class="ml-2">Wish List</span>
                              </li>
                    -->

                    <vs-divider class="m-1"/>

                    <li
                        class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
                        @click="logout">
                        <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4"/>
                        <span class="ml-2">{{ $t('Logout') }}</span>
                    </li>
                </ul>
            </vs-dropdown-menu>
        </vs-dropdown>
    </div>
</template>

<script>
export default {
    computed: {
        activeUserInfo () {
            return this.$store.getters['auth/getAdminInfo']
        }
    },
    methods: {
        logout () {
            this.$store.dispatch('auth/logoutAttempt', this)
            localStorage.removeItem('userInfo')

            // This is just for demo Purpose. If user clicks on logout -> redirect
            this.$router.push('/pages/login').catch(() => {
            })
        }
    }
}
</script>
