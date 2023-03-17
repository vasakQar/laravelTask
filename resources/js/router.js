import Vue from 'vue';
import Auth from './Auth';
import VueRouter from "vue-router";
Vue.use(VueRouter)

import Login from './components/login';
import Register from "./components/Register";
import Dashboard from "./components/dashboard";
import Products from "./components/product/index";
import ProductShow from "./components/product/show";

const routes = [
    {
        path: '/login',
        component: Login,
        name: "Login"
    },
    {
        path: '/register',
        component: Register,
        name: "Register"
    },
    {
        path: '/dashboard',
        component: Dashboard,
        name: "Dashboard",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/products',
        component: Products,
        name: "products-index",
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/product/show/:id',
        component: ProductShow,
        name: "product-show",
        meta: {
            requiresAuth: true
        },
        props: true
    }
];

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth) ) {
        if (Auth.check()) {
            next();
            return;
        } else {
            router.push('/login');
        }
    } else {
        next();
    }
});

export default router
