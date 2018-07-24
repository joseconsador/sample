<template>
    <div>

    </div>
</template>

<script>
    export default {
        mounted() {
            if (this.$store.state.user.hasRole('user') || this.$store.state.user.hasRole('owner')) {
                this.$router.push('/restaurants/1');
            }
        }
    }
</script>
