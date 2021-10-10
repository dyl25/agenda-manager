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

        <div 
        v-if="errors.length === 0"
        class="row mb-3"
        >

            <div class="row">

                <div 
                v-if="(currentDate.month() > defaultDate.month()) || (currentDate.year() > defaultDate.year())"
                class="col-lg-4">
                    <button @click="changeMonth('previous')" type="button" class="btn btn-primary"><i class="fas fa-arrow-left"></i></button>
                </div>
                <div class="col-lg-4">
                    <h2 class="fs-1 mb-2">{{ currentDate.format('MMMM YYYY') | capitalizeFirstLetter }}</h2>
                </div>
                <div class="col-lg-4">
                    <button @click="changeMonth('next')" type="button" class="btn btn-primary"><i class="fas fa-arrow-right"></i></button>
                </div>

            </div>

            <template v-if="!isServiceLoading">
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
            </template>
            <loader v-else />
        </div>

        <div v-else>
            <div class="notif-container">
                <card v-for="(err, index) in errors" :key="'err' + index" @click.native="clearError(index)" :message="err" type="danger" />
            </div>
        </div>

    </section>
</template>

<script>
import axios from "axios"
import BookingModal from './BookingModal.vue'
import Card from '../Card.vue'
import Loader from '../Loader.vue'

export default {
    name: "ServiceDisplay",

    components: {
        BookingModal,
        Card,
        Loader,
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

            let beginDay = 1

            if(
                this.currentDate.year() === this.defaultDate.year()
                && 
                this.currentDate.month() === this.defaultDate.month()
            ) {
                beginDay = this.defaultDate.date()
            }

            const params = {
                year: this.currentDate.year(),
                month: this.currentDate.month() +1,
                day: beginDay,
            }

            const headers = {
                'Content-Type': 'application/json'
            }

            axios
                .get(
                    this.allServicesUrl,
                    { params },
                    { headers },
                )
                .then(({ data }) => {
                    this.isServiceLoading = false;
                    this.remainingDates = data
                })
                .catch((error) => {
                    this.isServiceLoading = false;

                    this.pushError('Une erreur s\'est produite veuillez réessayer plus tard.')

                    console.log(error);
                });
        },

        changeMonth(direction) {

            if(direction === 'previous') {
                this.currentDate = this.currentDate.subtract(1, 'month')
            }

            if(direction === 'next') {
                this.currentDate = this.currentDate.add(1, 'month')
            }

            this.loadData()
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
