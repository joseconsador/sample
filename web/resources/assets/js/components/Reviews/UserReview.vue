<template>
    <div>
        <template v-if="hasReview">
            <review
                    :review="this.review"
                    :user="this.$store.state.user"
                    :owner="this.owner"
            />
        </template>
        <template v-else>
            <router-link
                class="nav-link"
                :to="{ name: 'addReview', params: { restaurantId: this.restaurantId } }"
            >
                Add a review
            </router-link>
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
            restaurantId: Number,
            owner: {}
        },
        data: function() {
            return {
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
                })
                .catch(error => {
                    if (error.response.status == 404) {
                        this.hasReview = false;
                    }
                });
        }
    }
</script>
