import Vue from 'vue'
import Router from 'vue-router'
import BookingList from './views/BookingList'
import Dashboard from './views/Dashboard'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/booking',
            name: 'booking',
            component: BookingList
        },
        {
            path: '/admin/dashboard',
            name: 'admin',
            component: Dashboard
        }
    ]
})