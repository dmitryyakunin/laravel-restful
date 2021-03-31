import Vue from 'vue'
import Router from 'vue-router'

import SearchProducts from '../components/SearchProducts.vue'
import Categories from '../components/Categories.vue'
import Products from '../components/Products.vue'
import AddProduct from '../components/AddProduct.vue'


Vue.use(Router)

const router = new Router({
    //mode: 'history',
    routes: [
        {
            path: '/',
            name: 'search-products',
            component: SearchProducts
        },
        {
            path: '/сategories',
            name: 'сategories',
            component: Categories
        },				
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/add-products',
            name: 'add-products',
            component: AddProduct
        },
    ]
})


export default router
