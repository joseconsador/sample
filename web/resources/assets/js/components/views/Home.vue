<template>
    <div>

    </div>
</template>

<script>
    export default {
        created() {
            if (this.$store.state.user.hasRole('user') || this.$store.state.user.hasRole('owner')) {
                this.$router.push('/restaurants/1');
            }
        }
    }
</script>
