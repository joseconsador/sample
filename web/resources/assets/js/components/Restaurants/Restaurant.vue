<template>
    <div>
        <div class="card">
            <!--        <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
            <div class="card-body">
                <h5 class="card-title">{{ name }}</h5>
                <p class="card-text">{{ description }}</p>
                <star-rating v-bind:rating="rating" read-only="true"/>
            </div>
        </div>
        <h4>Reviews</h4>
        <reviews v-bind:reviews="reviews"/>
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
            };
        },
        methods: {
            fetch: function() {
                axios.get('/api/restaurants/' + this.$route.params.id).then(resp => {
                    var restaurant = resp.data;
                    this.name = restaurant.data.attributes.name;
                    this.rating = restaurant.data.attributes.average_rating;

                    axios.get('/api/restaurants/' + this.$route.params.id + '/reviews').then(resp => {
                        this.reviews = resp.data.data;
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