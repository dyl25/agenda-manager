import Vue from 'vue'
import router from './router'
import dayjs from 'dayjs'
import 'dayjs/locale/fr';

require('./bootstrap');

Vue.prototype.$dayjs = dayjs

Vue.filter('formatTime', function (value) {
    let strVal = value.toString()

    const insertPos = 2

    if (strVal.length < 4) {
        let zeroStr = '0';
        const nbReapeat = 4 - strVal.length;
        strVal = zeroStr.repeat(nbReapeat) + strVal;
    }

    const hours = strVal.slice(0, insertPos)
    const minutes = strVal.slice(insertPos)

    return [hours, ':', minutes].join('');
})

Vue.filter('formatInputTime', function (value) {
    const strVal = value.toString()

    if (strVal.length === 3) {
        value = '0' + strVal
    }

    const hours = value.slice(0, 2)
    const minutes = value.slice(2)

    return [hours, ':', minutes].join('');
})

Vue.filter('capitalizeFirstLetter', function (value) {

    return value.charAt(0).toUpperCase() + value.slice(1);
})

new Vue({
    router: router,
}).$mount('#app')
