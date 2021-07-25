import Vue from 'vue'
import router from './router'
import dayjs from 'dayjs'
import 'dayjs/locale/fr';

require('./bootstrap');

Vue.prototype.$dayjs = dayjs

Vue.filter('formatTime', function(value) {
    const strVal = value.toString()

    let insertPos = 2
    
    if(strVal.length === 3) {
        insertPos = 1
    }

    const hours = value.slice(0, insertPos)
    const minutes = value.slice(insertPos)

    return [hours, ':', minutes].join('');

})

new Vue({
    router: router,
}).$mount('#app')
