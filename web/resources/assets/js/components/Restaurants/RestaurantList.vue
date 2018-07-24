<template>
    <div>
        <div v-for="restaurant in restaurants">
            <restaurant
                    v-bind:name=restaurant.attributes.name
                    description="jojo"
                    v-bind:rating=restaurant.attributes.average_rating
            />
        </div>
    </div>
</template>

<script>
    import Restaurant from './Restaurant.vue'

    export default {
        components: {
            'restaurant': Restaurant
        },
        props: ['restaurants'],
        name: "RestaurantList"
    }
</script>

<style scoped>

</style>