<template>
    <div>
        <h2>Restaurant</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ name }}</h5>
                <p class="card-text">{{ description }}</p>
                <star-rating
                        v-bind:rating="rating"
                        v-bind:starSize=30 />
            </div>
        </div>
        <p>
            <h4>Highlights</h4>
        </p>
        <hr/>
        <p>
            <h4>Reviews</h4>
        </p>
        <hr/>
        <reviews v-bind:reviews="reviews" v-bind:users="users" v-bind:ownerId="ownerId"/>
    </div>
</template>

<script>
    import Reviews from '../Reviews/ReviewList';
    import Rating from '../Reviews/Rating';

    export default {
        components: {
            'reviews': Reviews,
            'star-rating': Rating,
        },
        data: function() {
            return {
                name: "",
                description: "",
                rating: 0,
                reviews: {},
                users: [],
                ownerId: 0, // Restaurant owner ID
            };
        },
        methods: {
            fetch: function() {
                axios.get('/api/restaurants/' + this.$route.params.id + '?include=owner').then(resp => {
                    var restaurant = resp.data;
                    this.name = restaurant.data.attributes.name;
                    this.rating = restaurant.data.attributes.average_rating;
                    this.ownerId = restaurant.data.attributes.owner_id;

                    restaurant.included.forEach(resource => {
                        if (resource.type == "user") {
                            this.users[resource.id] = resource.attributes;
                        }
                    });

                    axios.get('/api/restaurants/' + this.$route.params.id + '/reviews?include=user').then(resp => {
                        this.reviews = resp.data.data;

                        var users = resp.data.included.users;

                        users.forEach(user => {
                            this.users[user.id] = user.attributes;
                        });
                    });
                });
            }
        },
        mounted: function() {
            this.fetch();
        },
        name: "Restaurant"
    }
</script>

<style scoped>

</style>