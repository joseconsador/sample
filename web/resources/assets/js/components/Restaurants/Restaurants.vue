<template>
    <div>
        <paginate
                v-model="page"
                :page-count="pageCount"
                :click-handler="load"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :page-link-class="'page-link'"
                :prev-class="'page-link'"
                :next-class="'page-link'"
        >
        </paginate>
        <restaurant-list v-bind:restaurants=restaurantData />
    </div>
</template>

<script>
    import RestaurantList from '../Restaurants/RestaurantList';
    import Paginate from 'vuejs-paginate';

    export default {
        components: {
            'restaurant-list': RestaurantList,
            'paginate': Paginate,
        },
        data: function () {
            return {
                restaurantData: {},
                page: 1,
                pageCount: 1,
            }
        },
        methods: {
            load: function(page) {
                this.$router.push('/restaurants/' + page);
            },
            fetch: function() {
                axios.get('/api/restaurants?page=' + this.$route.params.page).then(resp => {
                    this.restaurantData = resp.data.data;
                    this.pageCount = resp.data.meta.last_page;
                });
            }
        },
        watch: {
            '$route': function(to, from) {
                this.fetch()
            }
        },
        mounted: function() {
            this.fetch()
        }
    }
</script>
