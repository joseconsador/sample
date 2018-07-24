<template>
    <div>
        <star-rating v-bind:rating="review.rating" />
        <p>
            By: {{ user.name }} <br>
            <small>{{ review.updated_at | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</small>
        </p>
        <p>{{ review.comment }}</p>
        <div v-if="review.reply != ''" class="alert alert-warning" role="alert">
            <p><b>{{ owner.name }}: (Owner)</b></p>
            {{ review.reply }}
        </div>
    </div>
</template>

<script>
    import Rating from './Rating';

    export default {
        components: {
            'star-rating': Rating
        },
        props: ['review', 'user', 'owner'],
        name: "ReviewListItem"
    }
</script>

<style scoped>

</style>