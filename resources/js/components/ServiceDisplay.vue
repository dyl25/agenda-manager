<template>
    <section class="container">
        <div class="row mb-3">
            <h2 class="fs-1 mb-2">{{ currentDate.format('MMMM YYYY') }}</h2>

            <h3>Lundi 7 juillet</h3>

            <div class="col-lg-4">
                <div
                    class="card m-1"
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal"
                >
                    <div class="card-body clickable">
                        9:00 - Coaching personnel
                    </div>
                </div>
            </div>

            <div
                class="row"
                v-for="(date, index) in remainingDates"
                :key="'daySection' + index"
            >
            <h3>{{ date.format('dddd D') }}</h3>
                <h3>Lundi 7 juillet</h3>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";

export default {
    name: "ServiceDisplay",

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
        };
    },

    created() {
        this.loadData();
        this.getRemainingDates();
    },

    methods: {
        loadData() {
            this.isServiceLoading = true;

            axios
                .get(this.allServicesUrl)
                .then(({ data }) => {
                    this.isServiceLoading = false;

                    this.services = data;
                })
                .catch((error) => {
                    this.isServiceLoading = false;

                    console.log(error);
                });
        },

        getRemainingDates() {
            let addedDate = this.currentDate
            const monthEnd = addedDate.endOf('month')

            this.remainingDates.push(addedDate)

            while (!addedDate.isSame(monthEnd, 'day')) {
                addedDate = addedDate.add(1, 'day')
                this.remainingDates.push(addedDate)
            }
        },
    },
};
</script>
