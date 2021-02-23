<template>
    <div v-if="userId != null" class="chat__header">
        <vs-navbar class="p-4 flex navbar-custom" color="white" type="flat">
            <div class="relative flex mr-4">
                <feather-icon icon="MenuIcon" class="mr-4 cursor-pointer" v-if="isSidebarCollapsed"/>
                <!--             @click.stop="$emit('openContactsSidebar')"    -->
                <vs-avatar class="m-0 border-2 border-solid border-white" size="40px" :src="userDetails.image"/>
                <!--                @click.stop="$emit('showProfileSidebar', userId)"-->
<!--                <div class="h-3 w-3 border-white border border-solid rounded-full absolute right-0 bottom-0"
                     :class="'bg-' + getStatusColor(false)"></div>-->
            </div>
            <h6>{{ userDetails.name }}</h6>
            <vs-spacer></vs-spacer>
        </vs-navbar>
    </div>
</template>

<script>
export default {
    props: {
        userId: {
            type: Number,
            required: true
        },
        isPinnedProp: {
            type: Boolean,
            required: false,
            default :false
        },
        isSidebarCollapsed: {
            type: Boolean,
            required: true
        }
    },
    computed: {

        userDetails () {
            return this.$store.getters['chat/contact'](this.userId)
        },
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
        }
    },
    methods: {
        getUserStatus (isActiveUser) {
            return isActiveUser ? this.$store.state.AppActiveUser.status : this.userDetails.status
        }
    }
}

</script>

