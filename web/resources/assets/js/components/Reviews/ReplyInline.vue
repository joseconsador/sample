<template>
    <div>
        <template v-if="!showInput">
            <a href="javascript:void(0)" v-on:click="showInput = true">Leave a reply</a>
        </template>
        <template v-else-if="!submitted">
            <form v-on:submit="submit" action="">
                <div class="form-group">
                    <label for="reply">Replying to comment:</label>
                    <textarea v-model="reply" class="form-control" id="reply" placeholder="Leave a reply..." />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </template>
        <template v-else>
            <div class="alert alert-warning" role="alert">
                <p><b>{{ this.$store.state.user.attributes.name }} (Owner):</b></p>
                {{ reply }}
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            reviewId: {
                type: Number,
                required: true,
            },
            restaurantId: {
                type: Number,
                required: true,
            }
        },
        data: function() {
            return {
                showInput: false,
                reply: "",
                submitted: false,
            };
        },
        methods: {
            submit: function (event) {
                if (event) event.preventDefault();

                axios.post('/api/restaurants/' + this.restaurantId + '/reviews/' + this.reviewId + '/reply', {
                    reply: this.reply
                })
                    .then(resp => {
                        this.submitted = true;
                    });
            }
        }
    }
</script>

<style scoped>

</style>