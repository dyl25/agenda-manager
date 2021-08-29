<template>

<div>
<navbar />

<service-display all-services-url="/api/services" />
</div>

</template>
<script>

import Navbar from '../components/Navbar'
import ServiceDisplay from '../components/service/ServiceDisplay'

export default {
    name: 'BookingList',

    components: {
        Navbar,
        ServiceDisplay
    },
}

</script>