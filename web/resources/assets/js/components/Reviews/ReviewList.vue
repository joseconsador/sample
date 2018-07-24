<template>
    <ul class="list-group">
        <li class="list-group-item" v-for="review in reviews">
            <review
                    v-bind:id="review.id"
                    v-bind:rating="review.attributes.rating"
                    v-bind:comment="review.attributes.comment"
                    v-bind:reply="review.attributes.reply"
            />
        </li>
    </ul>
</template>

<script>
    import Review from './ReviewListItem';

    export default {
        components: {
          'review': Review
        },
        props: ['reviews'],
        name: "ReviewList"
    }
</script>

<style scoped>

</style>