<template>

<div>test Services</div>

</template>

<script>

export default {
    name: 'ServiceDisplay',

    props: {
        'servicesUrl': {
            type: String,
            required: true
        }
    },

    data() {
        return {
            services: [],
            isServiceLoading: false
        }
    },

    methods: {

        loadData() {

            this.isServiceLoading = true

            this.axios.get(this.servicesUrl)
            .then(({data}) => {
                this.isServiceLoading = false

                this.services = data
            })
            .catch(error => {
                this.isServiceLoading = false

                console.log(error);
            })
        }

    }
}
</script>
