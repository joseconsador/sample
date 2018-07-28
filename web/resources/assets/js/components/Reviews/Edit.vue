<template>
    <div>
        <form v-on:submit="submit" action="">
            <div class="form-group">
                <label for="rating">Rating</label>
                <star-rating
                    v-bind:rating.sync="rating"
                    v-bind:read-only="false"
                    v-bind:star-size="30"
                    :increment="1"
                />
            </div>
            <div class="form-group">
                <label for="comment">Comment</label>
                <textarea v-model="comment" class="form-control" id="comment" placeholder="Leave a comment..." />
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <errors :errors="errors" />
    </div>
</template>

<script>
    import Rating from './Rating';

    export default {
        components: {
            'star-rating': Rating,
        },
        props: {
            id: {
                type: Number,
            },
            restaurantId: {
                type: Number,
                required: true,
            }
        },
        data: function() {
            return {
                restaurant: {},
                comment: "",
                rating: 0,
                errors: {},
            }
        },
        methods: {
            submit: function(event) {
                if (event) event.preventDefault();

                let options = {
                    method: 'post',
                    url: '/api/restaurants/' + this.restaurantId + '/reviews/',
                    data: {
                        rating: this.rating,
                        comment: this.comment
                    },
                };

                if (this.id > 0) {
                    options.data.id = this.id;
                    options.method = 'put';
                    options.url += this.id.toString();
                }

                axios(options)
                    .then(resp => {
                        this.$router.push('/restaurant/' + this.restaurantId);
                    })
                    .catch(errors => {
                        this.errors = errors.errors;
                    });
            }
        },
        created: function() {
            axios.get('/api/restaurants/' + this.restaurantId)
                .then(resp => {
                    this.restaurant = resp.data.data;
                });

            if (_.isUndefined(this.id)) {
                return;
            }

            let url = '/api/restaurants/' + this.restaurantId + '/review';

            if (this.$store.state.user.hasRole('admin')) {
                url = '/api/restaurants/' + this.restaurantId + '/reviews/' + this.id;
            }

            axios.get(url)
                .then(resp => {
                    let review = resp.data.data.attributes;
                    this.comment =  review.comment;
                    this.rating = review.rating;
                });
        }
    }
</script>
