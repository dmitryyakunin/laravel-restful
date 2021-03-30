import Vue from 'vue'
import Router from 'vue-router'

import Categories from '../components/Categories.vue'


Vue.use(Router)

const router = new Router({
    //mode: 'history',
    routes: [
        { path: '/', name: 'сategories', component: Categories },
    ]
})

export default router
