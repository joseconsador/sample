<template>
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Rating</th>
                <th>Name</th>
                <th>Added</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr is="restaurant"
                    v-for="restaurant in restaurants"
                    v-bind:name=restaurant.attributes.name
                    description="jojo"
                    v-bind:rating=restaurant.attributes.average_rating
                    v-bind:id=restaurant.id
                    v-bind:dateAdded=restaurant.attributes.created_at
                ></tr>
            </tbody>
        </table>
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