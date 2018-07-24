<template>
    <star-rating v-bind:increment="0.01"
                 v-bind:max-rating="5"
                 v-bind:rating="rating"
                 v-bind:star-size=starSize
                 v-bind:read-only=readOnly
                 inactive-color="#000"
                 active-color="#f00"
    >
    </star-rating>
</template>

<script>
    import StarRating from 'vue-star-rating';

    export default {
        props: {
            rating: {
                type: Number,
                default: 0
            },
            starSize: {
                default: 20
            },
            readOnly: {
                default: true
            }
        },
        components: {
            'star-rating': StarRating
        },
        name: "Rating"
    }
</script>

<style scoped>

</style>