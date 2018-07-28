<template>
    <div>
        <star-rating v-bind:rating="review.rating" />
        <p>
            By: {{ user.attributes.name }} <br>
            <small>{{ review.updated_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</small>
        </p>
        <p>{{ review.comment }}</p>

        <reply-inline :reply="review.reply" :owner="owner" :restaurant-id="review.restaurant_id" :review-id="id" />

        <router-link
            v-if="id != undefined && (this.$store.state.user.hasRole('admin') || (review.user_id == this.$store.state.user.id))"
            :to="{ name: 'editReview', params: { restaurantId: review.restaurant_id, id: id } }"
        >Edit review</router-link>
    </div>
</template>

<script>
    import Rating from './Rating';
    import ReplyInline from './ReplyInline';

    export default {
        components: {
            'star-rating': Rating,
            'reply-inline': ReplyInline,
        },
        props: ['id', 'review', 'user', 'owner'],
        name: "ReviewListItem"
    }
</script>

<style scoped>

</style>