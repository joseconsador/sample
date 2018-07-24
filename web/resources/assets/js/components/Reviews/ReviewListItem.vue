<template>
    <div>
        <p>{{ rating }}</p>
        <p>{{ comment }}</p>
        <p>{{ reply }}</p>
    </div>
</template>

<script>
    export default {
        props: ['comment', 'id', 'rating', 'reply'],
        name: "ReviewListItem"
    }
</script>

<style scoped>

</style>