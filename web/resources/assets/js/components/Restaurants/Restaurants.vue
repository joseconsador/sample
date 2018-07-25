<template>
    <div>
        <div class="row">
            <div class="col-6">
                <paginate
                        v-model=currentPage
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
            </div>
            <div class="col-3">
                <slider id="name" ref="slider" v-bind="filterOptions" :rating="rating"></slider>
            </div>
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <restaurant-list v-bind:restaurants=restaurantData />
            </div>
        </div>
    </div>
</template>

<script>
    import RestaurantList from '../Restaurants/RestaurantList';
    import Paginate from 'vuejs-paginate';
    import VueSlider from 'vue-slider-component';

    export default {
        components: {
            'restaurant-list': RestaurantList,
            'paginate': Paginate,
            'slider': VueSlider,
        },
        props: {
            page: {
                type: Number,
                default: 1,
            },
            rating: {
                default: function() { return [0,5]; }
            }
        },
        data: function () {
            return {
                restaurantData: {},
                pageCount: 1,
                currentPage: this.page,
                filterOptions: {
                    max: 5,
                    interval: 1,
                    piecewise: true,
                    piecewiseLabel: true,
                },
            }
        },
        methods: {
            load: function(page) {
                this.$router.push('/restaurants/' + page);
            },
            fetch: function() {
                var uri = '/api/restaurants?page=' + this.page + '&rating=' + this.rating.join(':');

                axios.get(uri).then(resp => {
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
