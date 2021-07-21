import Vue from 'vue'
import router from './router'
import dayjs from 'dayjs'
import 'dayjs/locale/fr';

require('./bootstrap');

Vue.prototype.$dayjs = dayjs

new Vue({
    router: router,
}).$mount('#app')
