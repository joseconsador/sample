<template>
    <div>
        <template v-if="errors">
            <div class="row">
                <div class="col-12 mt-3">
                    <ul class="list-group">
                        <template v-for="field in displayError">
                            <li class="list-group-item list-group-item-danger" v-for="error in field">{{ error }}</li>
                        </template>
                    </ul>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        props: {
            errors: {
                type: [String, Object],
            }
        },
        computed: {
            displayError: function() {
                if (typeof this.errors === "string") {
                    return {error: [this.errors]};
                }

                return this.errors;
            }
        }
    }
</script>
