<template>
    <section class="container">

        <div class="notif-container" v-if="messages.length > 0">
            <card v-for="(msg, index) in messages" :key="'msg' + index" @click.native="clearMessage(index)" :message="msg" />
        </div>

        <div class="notif-container" v-if="errors.length > 0">
            <card v-for="(err, index) in errors" :key="'err' + index" @click.native="clearError(index)" :message="err" type="danger" />
        </div>

        <booking-modal
            v-if="isBookingModalVisible"
            @close-modal="isBookingModalVisible = false"
            @booking-success="pushNotif($event)"
            @booking-error="pushError($event)"
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
                        v-if="service.places > 0"
                        @click="selectBooking(service, dateObj.dateFormat, time)"
                    >
                        <div class="card-body clickable">
                            {{ time | formatTime }} - {{ service.service.name }} {{ service.places > 1 ? ' - ' + service.places + ' places' : null }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios"
import BookingModal from './BookingModal.vue'
import Card from '../Card.vue'

export default {
    name: "ServiceDisplay",

    components: {
        BookingModal,
        Card,
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
            messages: [],
            errors: [],
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
        },

        pushNotif(msg) {
            this.messages.push(msg)
        },

        clearMessage(index) {
            this.messages.splice(index, 1)
        },

        pushError(msg) {
            this.errors.push(msg)
        },

        clearError(index) {
            this.errors.splice(index, 1)
        },
    },
};
</script>
