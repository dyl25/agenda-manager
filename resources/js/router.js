import Vue from 'vue'
import Router from 'vue-router'
import BookingList from './views/BookingList'
import Dashboard from './views/Dashboard'
import CreateService from './views/admin/service/CreateService'

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/booking/choose',
            name: 'booking',
            component: BookingList
        },
        {
            path: '/admin/service/create',
            name: 'service-create',
            component: CreateService
        }
    ]
})