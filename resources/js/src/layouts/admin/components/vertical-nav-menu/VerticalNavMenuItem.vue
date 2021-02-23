<template>
    <div
        class="vs-sidebar--item"
        v-if="checkPermission"
        :class="[
      {'vs-sidebar-item-active'            : activeLink},
      {'disabled-item pointer-events-none' : isDisabled}
    ]">

        <router-link
            tabindex="-1"
            exact
            :class="[{'router-link-active': activeLink}]"
            :to="to"
            :target="target">
            <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon"/>
            <feather-icon v-else :class="{'w-3 h-3': iconSmall}" :icon="icon"/>

            <slot/>
        </router-link>
<!--
        <a v-else :target="target" :href="href" tabindex="-1">
            <vs-icon v-if="!featherIcon" :icon-pack="iconPack" :icon="icon"/>
            <feather-icon v-else :class="{'w-3 h-3': iconSmall}" :icon="icon"/>
            <slot/>
        </a>-->
    </div>
</template>

<script>
import ability from '@/services/ability'

export default {
    name: 'v-nav-menu-item-view',
    props: {
        icon: {
            type: String,
            default: ''
        },
        iconSmall: {
            type: Boolean,
            default: false
        },
        iconPack: {
            type: String,
            default: 'material-icons'
        },
        href: {
            type: [String, null],
            default: '#'
        },
        to: {
            type: [String, Object, null],
            default: null
        },
        slug: {
            type: String,
            default: null
        },
        role: {
            type: [String, null],
            default: null
        },
        index: {
            type: [String, Number],
            default: null
        },
        featherIcon: {
            type: Boolean,
            default: true
        },
        target: {
            type: String,
            default: '_self'
        },
        isDisabled: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        activeLink () {
            return !!((this.to === this.$route.path || this.$route.meta.parent === this.slug) && this.to)
        },
        checkPermission(){


            return  !(this.role!==null  && !this.$can(this.role))
        }
    }
}

</script>

