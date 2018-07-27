<template>
    <div class="container pb-5">
        <h1>Restaurant Reviews</h1>

        <div class="row">
            <ul class="nav">
                <template v-if="loggedIn">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="this.$store.state.user.hasRole('admin')">
                        <router-link class="nav-link" :to="{ name: 'users', params: {page: 1} }">Users</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" v-if="loggedIn" :to="{ name: 'logout' }">Logout</router-link>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link disabled">Welcome, {{ userName }}</a>
                    </li>
                </template>
                <template v-else>
                    <li class="nav-item">
                        <router-link class="nav-link"  :to="{ name: 'register' }">Sign Up</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" v-if="!loggedIn" :to="{ name: 'login' }">Login</router-link>
                    </li>
                </template>
            </ul>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            loggedIn() { return this.$store.state.loggedIn },
            userName() { return this.$store.state.user.name },
        }
    }
</script>