<template>
    <div>
        <restaurant-list v-bind:restaurants=restaurantData />
    </div>
</template>

<script>
    import RestaurantList from '../Restaurants/RestaurantList';
    export default {
        components: {
            'restaurant-list': RestaurantList
        },
        data: function () {
            return {
                restaurantData: {}
            }
        },
        mounted() {
            axios.get('/api/restaurants').then(resp => {
                this.restaurantData = resp.data.data;
            });
        }
    }
</script>
