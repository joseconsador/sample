import VueRouter from 'vue-router'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist';

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

const vuexLocalStorage = new VuexPersist({
    key: 'vuex', // The key to store the state on in the storage provider.
    storage: window.localStorage, // or window.sessionStorage or localForage
    // Function that passes the state and returns the state with only the objects you want to store.
    // reducer: state => state,
    // Function that passes a mutation and lets you decide if it should update the state in localStorage.
    // filter: mutation => (true)
});

// Global state store
const store = new Vuex.Store({
    plugins: [vuexLocalStorage.plugin],
    state: {
        loggedIn: false,
        user: {
            name: "",
            roles: {},
            hasRole: function(role) {
                let hasRole = false;
                this.roles.every(function (r, i) {
                    if (r.name == role) {
                        hasRole = true;
                        return false;
                    }

                    return true;
                });

                return hasRole;
            }
        }
    },
    mutations: {
        setUser (state, user) {
            state.user.name = user.attributes.name;
            state.user.roles = user.attributes.roles;
        },
        setLoggedIn (state, loggedIn) {
            state.loggedIn = loggedIn;
        },
    }
});

Vue.use(VueRouter);
Vue.use(require('vue-moment'));

import App from './components/views/App'
import Home from './components/views/Home'
import Auth from './components/views/Auth'
import Restaurants from './components/Restaurants/Restaurants'
import Restaurant from './components/Restaurants/Restaurant'

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
        },
        {
            path: '/restaurant/:id',
            name: 'restaurant',
            component: Restaurant,
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
