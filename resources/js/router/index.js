import Vue from 'vue'
import Router from 'vue-router'

import SearchProducts from '../components/SearchProducts.vue'
import Categories from '../components/Categories.vue'
import Products from '../components/Products.vue'
import AddProduct from '../components/AddProduct.vue'
import AddCategory from '../components/AddCategory.vue'

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
            path: '/categories',
            name: 'categories',
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
        {
            path: '/add-category',
            name: 'add-category',
            component: AddCategory
        },
    ]
})


export default router
