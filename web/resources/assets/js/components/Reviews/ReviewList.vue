<template>
    <ul class="list-group">
        <li class="list-group-item" v-for="review in reviews">
            <review
                    v-bind:id="review.id"
                    v-bind:review="review.attributes"
                    v-bind:user="getUser(review.attributes.user_id)"
                    v-bind:owner="getUser(ownerId)"
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
        props: ['reviews', 'users', 'ownerId'],
        methods: {
            getUser(id) {
                return this.users[id];
            }
        },
        name: "ReviewList"
    }
</script>

<style scoped>

</style>