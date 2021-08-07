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

                <h3>{{ dateObj.date.format('dddd D') }}</h3>

                <div 
                    class="col-lg-4"
                    v-for="(service, time) in dateObj.hours"
                    :key="'agendaCard' + time"
                >
                    <div
                        class="card m-1"
                        @click="selectBooking(service, dateObj.date, time)"
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
            services: [],
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

    watch: {
        services() {
            if(this.services.length > 0) {
                this.getRemainingDates()
            }
        }
    },

    methods: {
        loadData() {
            this.isServiceLoading = true;
            axios.get(this.allServicesUrl)
                .then(({ data }) => {
                    this.isServiceLoading = false;

                    this.services = data;
                })
                .catch((error) => {
                    this.isServiceLoading = false;

                    console.log(error);
                });
        },

        getSchedule(services) {

            let schedule = {}

            services.map(service => {
                service.times.map((time) => {
                    for(let i=+time.start_time; i < +time.end_time; i+= +service.duration) {
                        schedule[i] = service
                    }
                })
            })

            return schedule
        },

        getRemainingDates() {
            let addedDate = this.currentDate
            const monthEnd = addedDate.endOf('month').add(1, 'day');

            while (!addedDate.isSame(monthEnd, 'month')) {

                let cpt = 0
                let servicesArr = []

                while (cpt <= this.services.length -1) {

                    if(this.services[cpt]
                        .service_days
                        .includes(
                            addedDate
                                .locale('en')
                                .format('dddd')
                                .toLowerCase()
                        )
                    ) {
                        servicesArr.push(this.services[cpt])
                    }

                    cpt++
                }

                if(servicesArr.length > 0) {
                    this.remainingDates.push({
                        date: addedDate,
                        hours: this.getSchedule(servicesArr),
                        //services: servicesArr
                    })
                }

                addedDate = addedDate.add(1, 'day')
            }
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
