<template>
    <div>
        <template v-if="currentReply && !showInput">
            <div class="alert alert-warning" role="alert">
                <p><b>{{ owner.attributes.name }} (Owner):</b></p>
                {{ currentReply }}
            </div>
            <a v-if="(this.$store.state.user.hasRole('admin') || (owner.id == this.$store.state.user.id))"
               href="javascript:void(0)" v-on:click="showInput = true">
                Edit reply
            </a>
        </template>
        <template v-else-if="reviewId > 0 && (this.$store.state.user.hasRole('admin') || (owner.id == this.$store.state.user.id))">
            <a href="javascript:void(0)" v-on:click="showInput = true">Leave a reply</a>
        </template>

        <template v-if="!submitted && showInput">
            <form v-on:submit="submit" action="">
                <div class="form-group">
                    <label for="reply">Replying to comment:</label>
                    <textarea v-model="currentReply" class="form-control" id="reply" placeholder="Leave a reply..." />
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            reviewId: Number,
            restaurantId: Number,
            owner: {},
            reply: ""
        },
        data: function() {
            return {
                showInput: false,
                currentReply: this.reply,
                submitted: false,
            };
        },
        methods: {
            submit: function (event) {
                if (event) event.preventDefault();
                let url = '/api/restaurants/' + this.restaurantId + '/reviews/' + this.reviewId + '/reply';
                axios.post(url, { reply: this.currentReply })
                    .then(resp => {
                        this.reply = resp.data.data.attributes.reply;
                        this.showInput = false;
                        this.submitted = true;
                    });
            }
        },
    }
</script>
