<template>
    <div>
        <form v-on:submit="login" action="">
            <div class="form-group">
                <label for="email">Email address</label>
                <input  v-model="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input v-model="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
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
                    axios.get('/api/users/me').then(resp => {
                        this.$store.commit('setUser', resp.data.data);
                        this.$store.commit('setLoggedIn', true);
                        this.$router.push('/');
                    });
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