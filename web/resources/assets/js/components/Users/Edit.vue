<template>
    <div>
        <form v-on:submit="submit" action="">
            <div class="form-group">
                <label for="name">Name</label>
                <input  v-model="name" type="text" class="form-control" id="name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input  v-model="email" type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div v-if="!this.changePassword" class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="changePassword" v-model="changePassword">
                <label class="form-check-label" for="changePassword">Change Password</label>
            </div>
            <div v-if="this.changePassword" class="form-group">
                <label for="email">Password</label>
                <input  v-model="password" type="password" class="form-control" id="password" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select v-model="role" class="form-control" id="role">
                    <option value="user">User</option>
                    <option value="owner">Owner</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <errors :errors="errors" />
    </div>
</template>

<script>
    export default {
        props: ['id'],
        data: function() {
            return {
                name: "",
                email: "",
                role: "",
                password: "",
                changePassword: false,
                errors: {},
            }
        },
        methods: {
            submit: function(event) {
                if (event) event.preventDefault();

                let options = {
                    method: 'post',
                    url: '/api/users/',
                    data: {
                        name: this.name,
                        email: this.email,
                        role: this.role,
                    },
                };

                if (this.id > 0) {
                    options.data.id = this.id;
                    options.method = 'put';
                    options.url += this.id.toString();
                } else {
                    // Set a password for new users.
                    this.changePassword = true;
                }

                if (this.changePassword) {
                    options.data.password = this.password;
                    options.data.password_confirmation = this.password;
                }

                axios(options)
                    .then(resp => {
                        this.$router.push('/users/1');
                    })
                    .catch(errors => {
                        this.errors = errors.errors;
                    });
            },
            load: function() {
                if (this.id > 0) {
                    axios.get('/api/users/' + this.id)
                        .then(resp => {
                            this.name = resp.data.data.attributes.name;
                            this.email = resp.data.data.attributes.email;
                            this.role = resp.data.data.attributes.roles[0].name;
                        })
                        .catch(error => {
                            if (error.response.status == 403 || error.response.status == 404) {
                                this.$router.push('/');
                            }
                        });
                } else {
                    this.changePassword = true;
                }
            }
        },
        watch: {
            $route (to, from) {
                this.load();
            }
        },
        created: function() {
            this.load();
        },
        name: "UserEdit"
    }
</script>
