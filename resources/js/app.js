import Vue from 'vue'

require('./bootstrap');

import router from './router'

new Vue({
    router: router
}).$mount('#app')
