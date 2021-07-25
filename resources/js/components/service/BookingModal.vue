<template>
<modal @close-modal="closeModal">
    <template v-slot:content>
    <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button @click="closeModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <p>Modal body text goes here.</p>
    </div>
    <div class="modal-footer">
        <button @click="closeModal" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
    </template>
</modal>
</template>

<script>
import Modal from '../Modal'

export default {
    name: 'BookingModal',

    components: {
        Modal
    },

    methods: {
        closeModal: function() {
            this.$emit('close-modal')
        }
    }
}
</script>