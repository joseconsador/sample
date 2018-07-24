import VueRouter from 'vue-router'
import Vuex from 'vuex'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../resources/assets/js/bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


// Global state store
const store = new Vuex.Store({
    state: {
        loggedIn: localStorage.getItem('logged-in') || false,
    },
    mutations: {
        setLoggedIn (state, loggedIn) {
            localStorage.setItem('logged-in', loggedIn);
            state.loggedIn = loggedIn;
            console.log(state.loggedIn);
        },
    }
});

Vue.use(VueRouter);

import App from './components/views/App'
import Home from './components/views/Home'
import Auth from './components/views/Auth'
import Restaurants from './components/Restaurants/Restaurants'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/login',
            name: 'login',
            component: Auth,
        },
        {
            path: '/logout',
            name: 'logout',
            component: Auth,
            props: {
                shouldLogin: false
            }
        },
        {
            path: '/restaurants/:page',
            name: 'restaurants',
            component: Restaurants,
        }
    ],
});

// Setup auth guard
router.beforeEach((to, from, next) => {
    if (!['login', 'logout'].includes(to.name) && !store.state.loggedIn) {
        next('login');
    } else {
        next();
    }
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
