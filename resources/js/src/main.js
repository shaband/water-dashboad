import Vue from 'vue'
import App from './App.vue'
import Vuesax from 'vuesax'

Vue.use(Vuesax)
// Vue Router
import router from '@/router/index.js'
// Vuex Store
import store from './store/store'
// Vuesax Component Framework
// axios
import axios from './axios.js'

Vue.prototype.$http = axios
// API Calls
import './http/requests'
// Filters
import './filters/filters.js'
// Theme Configurations
import '../themeConfig.js'
// Globally Registered Components
import './globalComponents.js'
// Vuejs - Vue wrapper for hammerjs
import {VueHammer} from 'vue2-hammer'

Vue.use(VueHammer)
// PrismJS
import 'prismjs'
import 'prismjs/themes/prism-tomorrow.css'
// Vue select css
// Note: In latest version you have to add it separately
import 'vue-select/dist/vue-select.css'

// i18n
import i18n from './i18n/i18n'

import {abilitiesPlugin} from '@casl/vue'
import ability from './services/ability'

Vue.use(abilitiesPlugin, ability)

// VeeValidate
// import VeeValidate from 'vee-validate'
// Vue.use(VeeValidate)
// Google Maps
import * as GmapVue from 'gmap-vue'

Vue.use(GmapVue, {
    load: {
        // Add your API key here
        key: process.env.MIX_GMAP_API_KEY,
        libraries: 'places', // This is required if you use the Auto complete plug-in
        region: 'EG',
        language: 'ar'

    }
})
Vue.config.productionTip = false
new Vue({
    router,
    store,
    i18n,
    render: h => h(App)
}).$mount('#app')
