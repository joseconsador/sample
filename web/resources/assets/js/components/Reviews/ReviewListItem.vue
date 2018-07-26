<template>
    <div>
        <star-rating v-bind:rating="review.rating" />
        <p>
            By: {{ user.attributes.name }} <br>
            <small>{{ review.updated_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</small>
        </p>
        <p>{{ review.comment }}</p>
        <template v-if="review.reply">
            <div class="alert alert-warning" role="alert">
                <p><b>{{ owner.attributes.name }} (Owner):</b></p>
                {{ review.reply }}
            </div>
        </template>
        <template v-else-if="id != undefined && (this.$store.state.user.hasRole('admin') || (owner.id == this.$store.state.user.id))">
            <reply-inline :restaurant-id="review.restaurant_id" :review-id="id" />
        </template>

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