<template>
    <div>
        <template v-if="hasReview">
            <review
                    :id="this.id"
                    :review="this.review"
                    :user="this.$store.state.user"
                    :owner="this.owner"
            />
        </template>
        <template v-else>
            <router-link :to="{ name: 'addReview', params: { restaurantId: this.restaurantId } }">Add a review</router-link>
        </template>
    </div>
</template>

<script>
    import ListItem from './ReviewListItem';

    export default {
        components: {
            'review': ListItem
        },
        props: {
            reviewId: Number,
            restaurantId: {
                type: Number,
                required: true
            },
            owner: {}
        },
        data: function() {
            return {
                id: null,
                review: {},
                hasReview: {
                    type: Boolean,
                    default: false
                }
            }
        },
        name: "UserReview",
        created: function() {
            axios.get('/api/restaurants/' + this.restaurantId + '/review')
                .then(resp => {
                    this.hasReview = true;
                    this.review = resp.data.data.attributes;
                    this.id = resp.data.data.id;
                })
                .catch(error => {
                    if (error.response.status == 404) {
                        this.hasReview = false;
                    }
                });
        }
    }
</script>
