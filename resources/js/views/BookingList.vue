<template>

<div>
<Navbar />

<ServiceDisplay service-url="/api/services" />
</div>

</template>
<script>

import Navbar from '../components/Navbar'
import ServiceDisplay from '../components/ServiceDisplay'

export default {
    name: 'BookingList',

    components: [
        Navbar,
        ServiceDisplay,
    ],
}

</script>