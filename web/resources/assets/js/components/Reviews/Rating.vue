<template>
    <star-rating v-model="currentRating"
                 :increment="0.01"
                 :max-rating="5"
                 :star-size=starSize
                 :read-only=readOnly
                 inactive-color="#000"
                 active-color="#f00"
    >
    </star-rating>
</template>

<script>
    import StarRating from 'vue-star-rating';

    export default {
        props: {
            rating: {
                type: Number,
                default: 0
            },
            starSize: {
                default: 20
            },
            readOnly: {
                default: true
            }
        },
        data: function() {
            return {
                currentRating: this.rating
            };
        },
        watch: {
            rating: function(val) {
                this.currentRating = val;
            },
            currentRating: function(val) {
                this.$emit('update:rating', val);
            },
        },
        components: {
            'star-rating': StarRating
        },
        name: "Rating"
    }
</script>

<style scoped>

</style>