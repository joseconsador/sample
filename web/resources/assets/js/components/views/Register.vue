<template>
    <div>
        <form v-on:submit="register" action="">
            <div class="form-group">
                <label for="name">Your Name</label>
                <input  v-model="name" type="text" class="form-control" id="name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input  v-model="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="role">Register as</label>
                <select v-model="role" class="form-control" id="role">
                    <option value="user">User</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input v-model="password" type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input v-model="confirmPassword" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                name: "",
                email: "",
                role: "user",
                password: "",
                confirmPassword: ""
            }
        },
        methods: {
            register: function(event) {
                if (event) event.preventDefault();

                axios.post('/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.confirmPassword,
                    role: this.role
                }).then(resp => {

                });
            }
        }
    }
</script>
