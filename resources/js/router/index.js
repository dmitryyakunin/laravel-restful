import Vue from 'vue'
import Router from 'vue-router'

import Categories from '../components/Categories.vue'
import Products from '../components/Products.vue'


Vue.use(Router)

const router = new Router({
    //mode: 'history',
    routes: [
        { path: '/', name: 'сategories', component: Categories },
        { path: '/products', name: 'products', component: Products },
    ]
})

export default router
