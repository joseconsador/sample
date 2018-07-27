<template>
    <form v-on:submit="submit" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input  v-model="name" type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Name">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea v-model="description" class="form-control" id="description" placeholder="Description" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</template>

<script>
    export default {
        props: ['id'],
        data: function() {
            return {
                name: "",
                description: ""
            }
        },
        methods: {
            submit: function(event) {
                if (event) event.preventDefault();

                let options = {
                    method: 'post',
                    url: '/api/restaurants/',
                    data: {
                        name: this.name,
                        description: this.description
                    },
                };

                if (this.id > 0) {
                    options.data.id = this.id;
                    options.method = 'put';
                    options.url += this.id.toString();
                }

                axios(options).then(resp => {
                    this.$router.push('/restaurant/' + resp.data.data.id);
                });
            },
            load: function() {
                if (this.id > 0) {
                    axios.get('/api/restaurants/' + this.id)
                        .then(resp => {
                            this.name = resp.data.data.attributes.name;
                            this.description = resp.data.data.attributes.description;
                        })
                        .catch(error => {
                            if (error.response.status == 403 || error.response.status == 404) {
                                this.$router.push('/');
                            }
                        });
                } else {
                    this.name = "";
                    this.description = "";
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
        name: "RestaurantEdit"
    }
</script>
