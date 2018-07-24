<template>
    <div>
        <div class="card">
            <!--        <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
            <div class="card-body">
                <h5 class="card-title">{{ name }}</h5>
                <p class="card-text">{{ description }}</p>
                <star-rating
                        v-bind:rating="rating"
                        v-bind:read-only=false
                        v-bind:starSize=30 />
            </div>
        </div>
        <p>
            <h4>Reviews</h4>
        </p>
        <hr/>
        <reviews v-bind:reviews="reviews" v-bind:users="users"/>
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
                users: []
            };
        },
        methods: {
            fetch: function() {
                axios.get('/api/restaurants/' + this.$route.params.id).then(resp => {
                    var restaurant = resp.data;
                    this.name = restaurant.data.attributes.name;
                    this.rating = restaurant.data.attributes.average_rating;

                    axios.get('/api/restaurants/' + this.$route.params.id + '/reviews?include=user').then(resp => {
                        this.reviews = resp.data.data;

                        var users = resp.data.include.users;

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