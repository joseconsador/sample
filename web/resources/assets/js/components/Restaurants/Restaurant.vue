<template>
    <div>
        <div class="row mb-4">
            <div class="col-12">
                <h2>Restaurant</h2>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ name }}</h5>
                        <h6  class="card-subtitle mb-2">
                            <star-rating
                                    :rating="rating"
                                    :starSize=30 />
                        </h6>
                        <p class="card-text">{{ description }}</p>
                        <router-link
                                class="card-link"
                                v-if="this.$store.state.user.hasRole('owner')"
                                :to="{ name: 'editRestaurant', params: {id: id }}"
                        >Edit</router-link>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="this.$store.state.user.hasRole('user')" class="row mb-3">
            <div class="col-12">
                <h4>Your Review</h4>
                <hr>
                <ul class="list-group">
                    <li class="list-group-item">
                        <user-review :restaurant-id="this.id" :owner="this.users[ownerId]"/>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <h4>Highlights</h4>
                <hr>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <h4>Reviews</h4>
                <hr/>
                <reviews v-bind:reviews="reviews" v-bind:users="users" v-bind:ownerId="ownerId"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Reviews from '../Reviews/ReviewList';
    import Rating from '../Reviews/Rating';
    import UserReview from '../Reviews/UserReview';

    export default {
        props: {
            id: Number
        },
        components: {
            'reviews': Reviews,
            'star-rating': Rating,
            'user-review': UserReview,
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
                axios.get('/api/restaurants/' + this.id + '?include=owner')
                    .then(resp => {
                        var restaurant = resp.data;
                        this.name = restaurant.data.attributes.name;
                        this.rating = restaurant.data.attributes.average_rating;
                        this.ownerId = restaurant.data.attributes.owner_id;
                        this.description = restaurant.data.attributes.description;

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
                    })
                    .catch(error => {
                        if ([403, 404].includes(error.response.status)) {
                            this.$router.push('/');
                        }
                    });
            }
        },
        created: function() {
            this.fetch();
        },
        name: "Restaurant"
    }
</script>

<style scoped>

</style>