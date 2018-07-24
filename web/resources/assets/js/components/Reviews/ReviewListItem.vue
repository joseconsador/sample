<template>
    <div>
        <star-rating v-bind:rating="rating" />
        <p>By: {{ user.name }}</p>
        <p>{{ comment }}</p>
        <p>{{ reply }}</p>
    </div>
</template>

<script>
    import Rating from './Rating';

    export default {
        components: {
            'star-rating': Rating
        },
        props: ['comment', 'id', 'rating', 'reply', 'user'],
        name: "ReviewListItem"
    }
</script>

<style scoped>

</style>