<template>
    <div>
        <div class="row">
            <div class="col-3">
                <router-link class="nav-link" :to="{ name: 'addUser' }">Add User</router-link>
            </div>
        </div>
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
        </div>
        <div class="row">
            <div class="col-12">
                <user-list v-bind:users=userData :onDelete="deleteuser" />
            </div>
        </div>
    </div>
</template>

<script>
    import UserList from '../Users/UserList'
    import Paginate from 'vuejs-paginate';
    import VueSlider from 'vue-slider-component';

    export default {
        components: {
            'user-list': UserList,
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
                userData: {},
                pageCount: 1,
                currentPage: this.page,
            }
        },
        methods: {
            load: function(page) {
                this.currentPage = page;
                this.$router.push('/users/' + page);
            },
            fetch: function() {
                var uri = '/api/users?page=' + this.page;

                axios.get(uri).then(resp => {
                    this.userData = resp.data.data;
                    this.pageCount = resp.data.meta.last_page;
                });
            },
            deleteuser: function(id) {
                axios.delete('/api/users/' + id)
                    .then(resp => {
                        alert("Deleted user");
                        this.fetch();
                    });
            }
        },
        watch: {
            '$route': function(to, from) {
                this.fetch()
            }
        },
        created: function() {
            this.fetch()
        }
    }
</script>
