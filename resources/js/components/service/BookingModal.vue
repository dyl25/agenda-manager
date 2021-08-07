<template>
<modal @close-modal="closeModal">
    <template v-slot:content>
    <div class="modal-header">
        <h5 class="modal-title">Réservation: {{ currentServiceData.name }}</h5>
        <button @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form @submit.prevent="createBooking" method="POST" action="#">

            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label class="form-label">Date</label>
                    <input class="form-control" type="text" :value="currentDay.format('dddd D MMMM YYYY')"
                        readonly>
                </div>

                <div class="col-sm-6">
                    <label for="exampleFormControlInput1" class="form-label">Heure</label>
                    <input class="form-control" type="time" :value="currentTime | formatInputTime" readonly>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label for="emailInput" class="form-label">Email</label>
                    <input v-model="form.email" type="email" class="form-control" id="emailInput"
                        placeholder="name@example.com">
                </div>

                <div class="col-sm-6">
                    <label for="mobileInput" class="form-label">GSM</label>
                    <input v-model="form.mobile" type="tel" class="form-control" id="mobileInput"
                        placeholder="+324445566">
                </div>
            </div>

            <div class="mb-3 row">

                <div class="col-sm-6">
                    <label for="nameInput" class="form-label">Nom</label>
                    <input v-model="form.name" type="text" class="form-control" id="nameInput"
                        placeholder="Doe">
                </div>

                <div class="col-sm-6">
                    <label for="firstnameInput" class="form-label">Prénom</label>
                    <input v-model="form.firstname" type="text" class="form-control" id="firstnameInput"
                        placeholder="John">
                </div>

            </div>

            <div class="mb-5">
                <label for="commentsInput" class="form-label">Commentaires</label>
                <textarea v-model="form.comments" placeholder="Mon commentaire ..." class="form-control" id="commentsInput" rows="3"></textarea>
            </div>

            <div class="row">
                <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Confirmer</button>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <button @click="closeModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>
    </template>
</modal>
</template>

<script>
import axios from 'axios'
import Modal from '../Modal'

export default {
    name: 'BookingModal',

    props: {
        currentServiceData: {
            type: Object,
            required: true,
        },
        currentDay: {
            type: Object,
            required: true,
        },
        currentTime: {
            type: String,
            required: true,
        }
    },

    components: {
        Modal
    },

    data() {
        return {
            form: {
                user_id: null,
                service_id: this.currentServiceData.id,
                date: this.currentDay.format('YYYY-MM-DD'),
                time: this.currentTime,
                email: null,
                name: null,
                firstname: null,
                comments: null,
            },
            isCreatingBooking: false
        }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal')
        },

        createBooking() {
            this.isCreatingBooking = true

           // this.form.time = this.$options.filters.formatInputTime(this.form.time)

            let sendForm = {...this.form}
            console.log(sendForm);
            sendForm.time = this.$options.filters.formatInputTime(sendForm.time)

           axios.post('/api/bookings', sendForm)
            .then(({data}) => {
                this.isCreatingBooking = false
                console.log(data);
            })
            .catch(err => {
                this.isCreatingBooking = false
                console.log('Booking modal error: ' + err);
            })
        }

    }
}
</script>