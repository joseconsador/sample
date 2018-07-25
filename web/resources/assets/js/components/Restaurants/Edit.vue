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
        props: {
            id: {
                type: Number
            }
        },
        data: function() {
            return {
                name: "",
                description: ""
            }
        },
        methods: {
            submit: function(event) {
                if (event) event.preventDefault();
                axios.post('/api/restaurants', {
                    name: this.name,
                    description: this.description
                }).then(resp => {
                    this.$router.push('/restaurant/' + resp.data.data.id);
                });
            }
        },
        mounted: () => {
            if (this.id > 0) {
                axios.get('/api/restaurants/' + this.id).then(resp => {
                    this.name = resp.data.data.attributes.name;
                    this.description = resp.data.data.attributes.description;
                });
            }
        },
        name: "RestaurantEdit"
    }
</script>

<style scoped>

</style>