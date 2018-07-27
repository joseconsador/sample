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
                    :name="restaurant.attributes.name"
                    :description="restaurant.attributes.description"
                    :rating="restaurant.attributes.average_rating"
                    :id="restaurant.id"
                    :dateAdded="restaurant.attributes.created_at"
                    :onDelete="onDelete"
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
        props: ['restaurants', 'loader', 'onDelete'],
        name: "RestaurantList",
    }
</script>

<style scoped>

</style>