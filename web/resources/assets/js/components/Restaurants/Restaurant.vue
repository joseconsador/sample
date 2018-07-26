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
                <template v-if="reviews">
                    <reviews v-bind:reviews="reviews" v-bind:users="users" v-bind:ownerId="ownerId"/>
                    <a v-if="this.nextPage != null" v-on:click="load(nextPage)" href="javascript:void(0);">Load More</a>
                </template>
                <div v-if="loadingReviews" class="alert alert-secondary" role="alert">
                    Loading reviews..
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Reviews from '../Reviews/ReviewList';
    import Rating from '../Reviews/Rating';
    import UserReview from '../Reviews/UserReview';

    var urlParse = require("url-parse")

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
                reviews: [],
                users: [],
                ownerId: 0, // Restaurant owner ID
                nextPage: null,
                loadingReviews: true
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
                                this.users[resource.id] = resource;
                            }
                        });
                    })
                    .catch(error => {
                        if ([403, 404].includes(error.response.status)) {
                            this.$router.push('/');
                        }
                    });
            },
            load: function(url) {
                this.loadingReviews = true;
                this.nextPage = null;

                axios.get(url).then(resp => {
                    this.reviews = this.reviews.concat(resp.data.data);

                    if (!_.isNull(resp.data.links.next)) {
                        var parsed = urlParse(resp.data.links.next);
                        this.nextPage = parsed.pathname + parsed.query;
                    }

                    var users = resp.data.included.users;

                    users.forEach(user => {
                        this.users[user.id] = user;
                    });

                    this.loadingReviews = false;
                }).catch(error => {
                    console.log(error);
                    this.loadingReviews = false;
                });
            }
        },
        created: function() {
            this.fetch();
            this.load('/api/restaurants/' + this.id + '/reviews?include=user');
        },
        name: "Restaurant"
    }
</script>

<style scoped>

</style>