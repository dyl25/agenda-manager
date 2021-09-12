<template>
<modal @close-modal="closeModal">
    <template v-slot:content>
    <div class="modal-header">
        <h5 class="modal-title">Réservation: {{ currentServiceData.service.name }}</h5>
        <button @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form @submit.prevent="createBooking" method="POST" action="#">

            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label class="form-label">Date</label>
                    <input class="form-control" type="text" :value="currentDay.completeDate"
                        readonly>
                </div>

                <div class="col-sm-6">
                    <label for="exampleFormControlInput1" class="form-label">Heure</label>
                    <input class="form-control" type="time" :value="currentTime | formatTime" readonly>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label for="emailInput" class="form-label">Email</label>
                    <div class="input-group has-validation">
                        <input v-model="form.email" type="email" class="form-control" id="emailInput"
                            placeholder="name@example.com" :class="{'is-invalid' : formErrors.email}">
                        <div v-if="formErrors.email" class="invalid-feedback">
                            <span v-for="(inputErr, index) in formErrors.email" :key="'inputErr' + index">{{ inputErr }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="mobileInput" class="form-label">GSM</label>
                    <div class="input-group has-validation">
                        <input v-model="form.mobile" type="tel" class="form-control" id="mobileInput"
                            placeholder="+324445566" :class="{'is-invalid' : formErrors.mobile}">
                        <div v-if="formErrors.mobile" class="invalid-feedback">
                            <span v-for="(inputErr, index) in formErrors.mobile" :key="'inputErr' + index">{{ inputErr }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row">

                <div class="col-sm-6">
                    <label for="nameInput" class="form-label">Nom</label>
                    <div class="input-group has-validation">
                        <input v-model="form.name" type="text" class="form-control" id="nameInput"
                            placeholder="Doe" :class="{'is-invalid' : formErrors.name}">
                        <div v-if="formErrors.name" class="invalid-feedback">
                            <span v-for="(inputErr, index) in formErrors.name" :key="'inputErr' + index">{{ inputErr }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <label for="firstnameInput" class="form-label">Prénom</label>
                    <div class="input-group has-validation">
                        <input v-model="form.firstname" type="text" class="form-control" id="firstnameInput"
                            placeholder="John" :class="{'is-invalid' : formErrors.firstname}">
                        <div v-if="formErrors.firstname" class="invalid-feedback">
                            <span v-for="(inputErr, index) in formErrors.firstname" :key="'inputErr' + index">{{ inputErr }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mb-5">
                <label for="commentsInput" class="form-label">Commentaires</label>
                <div class="input-group has-validation">
                    <textarea v-model="form.comments" placeholder="Mon commentaire ..." class="form-control" id="commentsInput" rows="3" :class="{'is-invalid' : formErrors.comments}"></textarea>
                    <div v-if="formErrors.comments" class="invalid-feedback">
                            <span v-for="(inputErr, index) in formErrors.comments" :key="'inputErr' + index">{{ inputErr }}</span>
                    </div>
                </div>
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
                service_id: this.currentServiceData.service.id,
                date: this.currentDay.date,
                time: this.currentTime,
                email: null,
                name: null,
                firstname: null,
                comments: null,
            },
            isCreatingBooking: false,
            currentService: this.currentServiceData,
            formErrors: {},
        }
    },

    methods: {
        closeModal() {
            this.$emit('close-modal')
        },

        createBooking() {
            this.isCreatingBooking = true

            let sendForm = {...this.form}
            sendForm.time = this.$options.filters.formatTime(sendForm.time)

           axios.post('/api/bookings', sendForm)
            .then(({data}) => {
                this.isCreatingBooking = false
                this.currentService.places--
                this.$emit('booking-success', 'Le service a bien été réseré.')
            })
            .catch(err => {
                this.isCreatingBooking = false
                console.log('Booking modal error: ' + err);

                if(err.response.status === 422) {
                    this.formErrors = err.response.data.errors
                }else {
                    this.$emit('booking-error', 'Une erreur s\'est produite veuillez réessayer plus tard.')
                }
            })
        }

    }
}
</script>