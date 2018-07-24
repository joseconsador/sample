<template>
    <div>
        <div v-for="restaurant in restaurants">
            <restaurant
                    v-bind:name=restaurant.attributes.name
                    description="jojo"
                    v-bind:rating=restaurant.attributes.average_rating
                    v-bind:id=restaurant.id
            />
        </div>

    </div>
</template>

<script>
    import Restaurant from './RestaurantListItem.vue';

    export default {
        components: {
            'restaurant': Restaurant,
        },
        props: ['restaurants', 'loader'],
        name: "RestaurantList",
    }
</script>

<style scoped>

</style>