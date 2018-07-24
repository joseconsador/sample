<template>
    <div class="card" style="width: 18rem;">
<!--        <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
        <div class="card-body">
            <h5 class="card-title">{{ name }}</h5>
            <p class="card-text">{{ description }}</p>
            <star-rating v-bind:rating="rating" v-bind:star-size="14" />

            <router-link :to="{ name: 'restaurant', params: {id: id }}">View</router-link>
        </div>
    </div>
</template>

<script>
    import Rating from '../Reviews/Rating'

    export default {
        components: {
            'star-rating': Rating,
        },
        props: {
            id: {
                type: Number,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: false,
                default: "Some quick example text to build on the card title and make up the bulk of the card's"
            },
            rating: {
                type: Number,
                require: true
            }
        },
        name: "RestaurantListItem"
    }
</script>

<style scoped>

</style>