<template>
<div class="modal d-block" tabindex="-1">
    <div class="modal-dialog shadow">
        <div class="modal-content">
            <slot name="content"></slot>
        </div>
    </div>
</div>
</template>

<script>

export default {
    name: 'Modal',

    methods: {
        closeModal: function() {
            this.$emit('close-modal')
        }
    }
}
</script>