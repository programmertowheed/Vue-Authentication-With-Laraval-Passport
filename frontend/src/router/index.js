import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from "../views/Home";
import Login from "../views/Login";
import store from "../store";
import Register from "../views/Register";
import Blog from "../views/Blog";

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta:{
            visitor: true
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta:{
            visitor: true
        }
    },
    {
        path: '/about',
        name: 'About',
        component: () => import('../views/About'),
        meta:{
            requiresAuth: true
        }
    },
    {
        path: '/blog',
        name: 'Blog',
        component: Blog,
        meta:{
            requiresAuth: true
        }
    }

]


const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.loggedIn) {
            next({
                name: 'Login'
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.visitor)) {
        if (store.getters.loggedIn) {
            next({
                name: 'Home'
            })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router