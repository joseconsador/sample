<template>
    <div>
        <h1>Restaurant Reviews</h1>

        <p>
            <router-link :to="{ name: 'home' }">Home</router-link> |
            <router-link v-if="!loggedIn" :to="{ name: 'login' }">Login</router-link>
            <router-link v-if="loggedIn" :to="{ name: 'logout' }">Logout</router-link>
        </p>

        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        computed: {
            loggedIn() { return this.$store.state.loggedIn }
        }
    }
</script>