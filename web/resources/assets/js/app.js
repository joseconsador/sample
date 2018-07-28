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
            id: null,
            attributes: {},
            name: "",
            roles: {},
            hasRole: function(role) {
                let hasRole = false;
                if (!_.isEmpty(this.roles)) {
                    this.roles.every(function (r, i) {
                        if (r.name == 'admin' || r.name == role) {
                            hasRole = true;
                            return false;
                        }

                        return true;
                    });
                }

                return hasRole;
            }
        }
    },
    mutations: {
        setUser (state, user) {
            if (user == null) {
                state.user.id = null;
                state.user.name = "";
                state.user.roles = {};
                state.user.attributes = {};
            } else {
                state.user.id = user.id;
                state.user.attributes = user.attributes;
                state.user.name = user.attributes.name;
                state.user.roles = user.attributes.roles;
            }
        },
        setLoggedIn (state, loggedIn) {
            if (loggedIn == false) {
                this.commit('setUser', null);
            }
            state.loggedIn = loggedIn;
        },
    }
});

Vue.use(VueRouter);
Vue.use(require('vue-moment'));

import Errors from './components/Errors';
import App from './components/views/App'
import Home from './components/views/Home'
import Auth from './components/views/Auth'
import Register from './components/views/Register'
import Restaurants from './components/Restaurants/Restaurants'
import Restaurant from './components/Restaurants/Restaurant'
import EditRestaurant from './components/Restaurants/Edit'
import EditReview from './components/Reviews/Edit'
import Users from './components/Users/Users'
import EditUser from './components/Users/Edit'

// Globally include the error component
Vue.component('errors', Errors);

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
            path: '/register',
            name: 'register',
            component: Register,
        },
        {
            path: '/users/:page(\\d+)',
            name: 'users',
            component: Users,
            props: (route) => ({
                page: Number(route.params.page)
            }),
        },
        {
            path: '/user/edit/:id(\\d+)',
            name: 'editUser',
            component: EditUser,
            props: (route) => ({
                id: Number(route.params.id)
            }),
        },
        {
            path: '/user/new',
            name: 'addUser',
            component: EditUser,
        },
        {
            path: '/restaurants/:page(\\d+)',
            name: 'restaurants',
            component: Restaurants,
            props: (route) => ({
                page: Number(route.params.page)
            }),
        },
        {
            path: '/restaurant/:id(\\d+)',
            name: 'restaurant',
            component: Restaurant,
            props: (route) => ({
                id: Number(route.params.id)
            }),
        },
        {
            path: '/restaurant/:restaurantId(\\d+)/review/new',
            name: 'addReview',
            component: EditReview,
            props: (route) => ({
                restaurantId: Number(route.params.restaurantId)
            }),
        },
        {
            path: '/restaurant/:restaurantId(\\d+)/review/:id(\\d+)/edit',
            name: 'editReview',
            component: EditReview,
            props: (route) => ({
                restaurantId: Number(route.params.restaurantId),
                id: Number(route.params.id)
            }),
        },
        {
            path: '/restaurant/new',
            name: 'addRestaurant',
            component: EditRestaurant,
        },
        {
            path: '/restaurant/edit/:id(\\d+)',
            name: 'editRestaurant',
            component: EditRestaurant,
            props: true
        },
    ],
});

// Setup auth guard
router.beforeEach((to, from, next) => {
    if (!['login', 'logout', 'register'].includes(to.name) && !store.state.loggedIn) {
        next('login');
    } else if (['users', 'editUser', 'addUser'].includes(to.name) && !store.state.user.hasRole('admin')) {
        next('/')
    } else if (['addRestaurant', 'editRestaurant'].includes(to.name) && !store.state.user.hasRole('owner')) {
        next('/')
    } else if (['addReview', 'editReview'].includes(to.name) && !store.state.user.hasRole('user')) {
        next('/')
    } else {
        next();
    }
});

// Add a response interceptor
window.axios.interceptors.response.use(function (response) {
    // Do something with response data
    return response;
}, function (error) {
    if (error.response.status == 401) {
        store.commit('setLoggedIn', false);
        router.push('/login');
    }

    if ([401, 422].includes(error.response.status)) {
        error.errors = error.response.data.errors || error.response.data.message;
    }

    // Do something with response error
    return Promise.reject(error);
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store,
});
