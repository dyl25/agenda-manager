<template>
    <div class="card text-white mb-3" :class="cardBg" style="max-width: 18rem;">
        <div class="card-body">
            <p class="card-text">{{ message }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "Card",

    props: {
        message: {
            type: String,
            required: true
        },

        type: {
            type: String,
            required: false,
            default: 'success'
        }
    },

    computed: {
        cardBg() {
            return 'bg-' + this.type
        }
    }
}
</script>
