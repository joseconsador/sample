<template>
    <tr>
        <td><star-rating v-bind:rating="rating" v-bind:star-size="14" /></td>
        <td>{{ name }}</td>
        <td>{{ dateAdded | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
        <td>
            <router-link :to="{ name: 'restaurant', params: {id: id }}">View</router-link>
            <router-link v-if="this.$store.state.user.hasRole('owner')" :to="{ name: 'editRestaurant', params: {id: id }}">Edit</router-link>
            <a v-on:click="onDelete(id)" v-if="this.$store.state.user.hasRole('owner')" href="javascript:void(0)">Delete</a>
        </td>
    </tr>
</template>

<script>
    import Rating from '../Reviews/Rating'

    export default {
        components: {
            'star-rating': Rating,
        },
        props: {
            id: {
                type: Number,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: false,
                default: "",
            },
            rating: {
                type: Number,
                require: true
            },
            dateAdded: {
                default: Date.now()
            },
            onDelete: Function
        },
        name: "RestaurantListItem"
    }
</script>

<style scoped>

</style>