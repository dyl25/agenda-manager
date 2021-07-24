<template>
    <div>
        <h3 class="my-3">Création d'une prestation</h3>

        <form @submit.prevent="createService" action="#">
            <div class="mb-3 row">
                <label for="serviceName" class="form-label">Nom</label>
                <input
                    v-model.trim="form.name"
                    class="form-control"
                    type="text"
                    id="serviceName"
                    name="serviceName"
                >
            </div>

            <div class="mb-3 row">
                <div class="col-sm-6">
                    <fieldset>
                        <legend>Fréquence par jour</legend>

                        <div class="form-check form-check-inline">
                            <input
                                @change="checkAllDays($event)"
                                class="form-check-input"
                                type="checkbox"
                                id="cbAlldays"
                                value="allDays"
                                name="cbAlldays"
                            >
                            <label class="form-check-label" for="cbAlldays"
                                >Tous les jours</label
                            >
                        </div>

                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbMonday"
                                value="monday"
                                name="cbMonday"
                            >
                            <label class="form-check-label" for="cbMonday"
                                >Lundi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbTuesday"
                                value="tuesday"
                                name="cbTuesday"
                            >
                            <label class="form-check-label" for="cbTuesday"
                                >Mardi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbWednesday"
                                value="wednesday"
                                name="cbWednesday"
                            >
                            <label class="form-check-label" for="cbWednesday"
                                >Mercredi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbThursday"
                                value="thursday"
                                name="cbThursday"
                            >
                            <label class="form-check-label" for="cbThursday"
                                >Jeudi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbFriday"
                                value="friday"
                                name="cbFriday"
                            >
                            <label class="form-check-label" for="cbFriday"
                                >Vendredi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbSaturday"
                                value="saturday"
                                name="cbSaturday"
                            >
                            <label class="form-check-label" for="cbSaturday"
                                >Samedi</label
                            >
                        </div>
                        <div class="form-check form-check-inline">
                            <input
                                v-model="form.days"
                                class="form-check-input"
                                type="checkbox"
                                id="cbSunday"
                                value="sunday"
                                name="cbSunday"
                            >
                            <label class="form-check-label" for="cbSunday"
                                >Dimanche</label
                            >
                        </div>
                    </fieldset>
                </div>

                <div class="col-sm-6">
                    <fieldset>
                        <legend>Fréquence par heure</legend>

                        <div
                            v-for="(hour, index) in form.hours"
                            :key="'hourSection' + index"
                            class="mb-3 row"
                        >
                            <div class="col-sm-1">
                                <button v-if="form.hours.length > 1" @click="removeTimePeriod(index)" type="button" class="btn btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>

                            <div class="col-sm-5">
                                <label
                                    for="exampleFormControlInput1"
                                    class="form-label"
                                    >Première prestation à</label
                                >
                                <input
                                    v-model="form.hours[index].startTime"
                                    class="form-control"
                                    type="time"
                                    :id="'frequencyStart' + index"
                                    :name="'frequencyStart' + index"
                                >
                            </div>

                            <div class="col-sm-6">
                                <label
                                    for="exampleFormControlInput1"
                                    class="form-label"
                                    >Dernière prestation à</label
                                >
                                <input
                                    v-model="form.hours[index].endTime"
                                    class="form-control"
                                    type="time"
                                    :id="'frequencyEnd' + index"
                                    :name="'frequencyEnd' + index"
                                >
                            </div>
                        </div>

                        <div class="row text-centered">
                            <button
                                v-if="form.hours.length < 2"
                                @click="addTimePeriod()"
                                type="button"
                                class="btn btn-success"
                            >
                                Ajouter une période
                            </button>
                        </div>
                    </fieldset>
                </div>
            </div>

            <div class="mb-3 row">
                <div class="col-sm-4">
                    <label for="duration" class="form-label"
                        >Durée</label
                    >
                    <input v-model="form.duration" name="duration" id="duration" class="form-control" type="time">
                </div>

                <div class="col-sm-4">
                    <label for="places" class="form-label"
                        >Places</label
                    >
                    <input v-model.number="form.places" name="places" id="places" class="form-control" type="number">
                </div>

                <div class="col-sm-4">
                    <label for="price" class="form-label"
                        >Prix</label
                    >
                    <input v-model.number="form.price" name="price" id="price" class="form-control" type="number" >
                </div>
            </div>

            <div class="row text-centered">
                <button type="submit" class="btn btn-success">Ajouter</button>
            </div>
        </form>
    </div>
</template>
<script>
export default {
    name: "CreateService",

    components: {},

    data() {
        return {
            isLoadingSend: false,
            defaultHourses: {
                startTime: "08:00",
                endTime: "16:00",
            },
            form: {
                name: "",
                days: [],
                hours: [],
                places: 1,
                duration: "01:00",
                price: 0,
            },
            weekDays: [
                "monday",
                "tuesday",
                "wednesday",
                "thursday",
                "friday",
                "saturday",
                "sunday",
            ],
        };
    },

    created() {
        this.initForm()
    },

    methods: {
        initForm() {
            this.form.hours.push(Object.assign({}, this.defaultHourses))
        },

        addTimePeriod() {
            if (this.form.hours.length < 2) {
                this.form.hours.push(Object.assign({}, this.defaultHourses))
            }
        },

        removeTimePeriod(index) {
            this.form.hours.splice(index, 1)
        },

        checkAllDays(event) {
            this.form.days = []

            if (event.target.checked) {
                this.form.days = this.weekDays
            }
        },

        createService() {
            this.isLoadingSend = true

            axios.post('/api/services', this.form)
            .then(({data}) => {
                this.isLoadingSend = false
            })
            .catch(err => {
                this.isLoadingSend = false
                console.log(err);
            })
        }
    },
};
</script>