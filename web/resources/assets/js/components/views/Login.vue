<template>
    <div>
        <form v-on:submit="login" action="">
            <input type="text" v-model="email" placeholder="Email" />
            <input type="password"  v-model="password" placeholder="Password" />
            <button>Login</button>
        </form>
        <button v-on:click="test">test</button>
    </div>
</template>
<script>
    export default {
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
                });
            },
            test: function () {
                axios.get('/api/restaurants')
                    .then(response => {
                        console.log(response.data);
                    });
            }
        }
    }
</script>