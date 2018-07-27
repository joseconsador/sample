<template>
    <tr>
        <td>{{ id }}</td>
        <td>{{ name }}</td>
        <td>{{ email }}</td>
        <td>{{ userRole }}</td>
        <td>{{ dateAdded | moment("dddd, MMMM Do YYYY, h:mm:ss a") }}</td>
        <td>
            <template v-if="this.$store.state.user.hasRole('admin')">
                <router-link :to="{ name: 'editUser', params: {id: id }}">Edit</router-link>
                <a v-on:click="onDelete(id)"  href="javascript:void(0)">Delete</a>
            </template>
        </td>
    </tr>
</template>

<script>
    export default {
        props: {
            id: {
                type: Number,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            email: {
                type: String,
                required: false,
            },
            role: {
                type: Array,
                required: true
            },
            dateAdded: {
                default: Date.now()
            },
            onDelete: Function
        },
        computed: {
            userRole: function() {
                return this.role[0].name;
            }
        },
        name: "userListItem"
    }
</script>

<style scoped>

</style>