<template>
    <div class="container">
        <h1>Restaurant Reviews</h1>

        <ul class="nav">
            <li class="nav-item">
                <router-link class="nav-link" :to="{ name: 'home' }">Home</router-link>
            </li>
            <li class="nav-item" v-if="this.$store.state.user.hasRole('owner') || this.$store.state.user.hasRole('admin')">
                <router-link class="nav-link" :to="{ name: 'addRestaurant' }">Add Restaurant</router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" v-if="!loggedIn" :to="{ name: 'login' }">Login</router-link>
                <router-link class="nav-link" v-if="loggedIn" :to="{ name: 'logout' }">Logout</router-link>
            </li>
            <li v-if="loggedIn" class="nav-item">
                <a href="#" class="nav-link disabled">Welcome, {{ userName }}</a>
            </li>
        </ul>

        <div class="container">
            <router-view></router-view>
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