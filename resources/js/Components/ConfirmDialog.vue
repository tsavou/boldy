<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    show: Boolean,
    message: String,
});
const emit = defineEmits(['confirm', 'cancel']);
</script>

<template>
    <Modal :show="show" @close="emit('cancel')" max-width="md">
        <div class="p-6">
            <h2 class="mb-4 text-lg font-bold">Confirmation</h2>
            <p class="mb-6 text-gray-700">{{ message }}</p>

            <div class="flex justify-end gap-3">
                <PrimaryButton
                    as="button"
                    color="secondary"
                    @click="emit('cancel')"
                >
                    Annuler
                </PrimaryButton>
                <PrimaryButton as="button" color="red" @click="emit('confirm')">
                    Supprimer
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
