<template>
    <div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
                <tr is="user"
                    v-for="user in users"
                    :name="user.attributes.name"
                    :email="user.attributes.email"
                    :id="user.id"
                    :dateAdded="user.attributes.created_at"
                    :onDelete="onDelete"
                    :role="user.attributes.roles"
                ></tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import user from './userListItem.vue';

    export default {
        components: {
            'user': user,
        },
        props: ['users', 'onDelete'],
        name: "userList",
    }
</script>
