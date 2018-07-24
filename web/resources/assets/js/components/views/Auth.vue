<template>
    <div>
        <form v-on:submit="login" action="">
            <input type="text" v-model="email" placeholder="Email" />
            <input type="password"  v-model="password" placeholder="Password" />
            <button>Login</button>
        </form>
    </div>
</template>
<script>
    export default {
        props: {
            'shouldLogin': {
                type: Boolean,
                default: true
            }
        },
        data: function() {
            return {
                email: "",
                password: "",
            }
        },
        methods: {
            login: function (event) {
                if (event) event.preventDefault();
                axios.post('/login', {
                    email: this.email,
                    password: this.password
                }).then(resp => {
                    this.$store.commit('setLoggedIn', true);
                    this.$router.push('/');
                    return resp;
                }).catch(err => {
                    this.$store.commit('setLoggedIn', false);
                    return err;
                });
            },
            logout: function () {
                axios.delete('/logout').then(resp => {
                    this.$store.commit('setLoggedIn', false);
                    this.$router.push('/login');
                    return resp;
                });
            }
        },
        mounted: function () {
            if (!this.shouldLogin) {
                this.logout();
            }
        }
    }
</script>