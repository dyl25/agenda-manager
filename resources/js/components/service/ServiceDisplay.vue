<template>
    <section class="container">

        <booking-modal
            v-if="isBookingModalVisible"
            @close-modal="isBookingModalVisible = false"
            :current-service-data="selectedService"
            :current-day="selectedDay"
            :current-time="selectedTime"
        />

        <div class="row mb-3">
            <h2 class="fs-1 mb-2">{{ currentDate.format('MMMM YYYY') }}</h2>

            <div
                class="row"
                v-for="(dateObj, index) in remainingDates"
                :key="'daySection' + index"
            >

                <h3>{{ dateObj.dateFormat.day }}</h3>

                <div 
                    class="col-lg-4"
                    v-for="(service, time) in dateObj.hours"
                    :key="'agendaCard' + time"
                >
                    <div
                        class="card m-1"
                        @click="selectBooking(service, dateObj.dateFormat, time)"
                    >
                        <div class="card-body clickable">
                            {{ time | formatTime }} - {{ service.name }} {{ service.places > 1 ? ' - ' + service.places + ' places' : null }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import BookingModal from './BookingModal.vue';

export default {
    name: "ServiceDisplay",

    components: {
        BookingModal,
    },

    props: {
        allServicesUrl: {
            type: String,
            required: true,
        },

        defaultDate: {
            type: Object,
            required: false,
            default() {
                return this.$dayjs().locale("fr");
            },
        },
    },

    data() {
        return {
            isServiceLoading: false,
            currentDate: this.defaultDate,
            remainingDates: [],
            isBookingModalVisible: false,
            selectedService: null,
            selectedDay: null,
            selectedTime: null,
        };
    },

    created() {
        this.loadData();
    },

    methods: {
        loadData() {
            this.isServiceLoading = true;
            axios.get(this.allServicesUrl)
                .then(({ data }) => {
                    this.isServiceLoading = false;
                    this.remainingDates = data
                })
                .catch((error) => {
                    this.isServiceLoading = false;

                    console.log(error);
                });
        },

        selectBooking(service, day,time) {
            this.isBookingModalVisible = true

            this.selectedService = service
            this.selectedDay = day
            this.selectedTime = time
        }
    },
};
</script>
