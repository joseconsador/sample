<template>
    <div class="card" style="width: 18rem;">
<!--        <img class="card-img-top" src=".../100px180/" alt="Card image cap">-->
        <div class="card-body">
            <h5 class="card-title">{{ name }}</h5>
            <p class="card-text">{{ description }}</p>
            <p class="card-text">{{ rating }}</p>
            <a href="#" class="btn btn-primary">Review</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: false,
                default: "Some quick example text to build on the card title and make up the bulk of the card's"
            },
            rating: {
                type: String,
                require: true
            }
        },
        name: "Restaurant"
    }
</script>

<style scoped>

</style>