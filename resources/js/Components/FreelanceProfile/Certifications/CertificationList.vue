<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
    AcademicCapIcon,
    PlusIcon,
    PencilIcon,
    TrashIcon,
} from '@heroicons/vue/24/solid';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import Modal from '@/Components/Modal.vue';
import CertificationForm from '@/Components/FreelanceProfile/Certifications/CertificationForm.vue';

defineProps({
    certifications: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const showModal = ref(false);
const selectedCert = ref(null);
const showConfirm = ref(false);
const certToDelete = ref(null);

// Ouvre la modale pour ajouter (cert = null) ou modifier (cert != null) une certification
const openModal = (cert = null) => {
    selectedCert.value = cert;
    showModal.value = true;
};

const handleSubmitted = () => {
    showModal.value = false;
    notify();
};
const notify = () => {
    emit('notify');
};

// Ouvre la modale de confirmation pour supprimer une certification en passant l'id de la certification à supprimer
const requestDeleteCert = (certId) => {
    certToDelete.value = certId;
    showConfirm.value = true;
};

const confirmDelete = () => {
    useForm().delete(route('certifications.destroy', certToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            notify();
            showConfirm.value = false;
            certToDelete.value = null;
        },
    });
};

const cancelDelete = () => {
    showConfirm.value = false;
    certToDelete.value = null;
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <h2 class="flex items-center text-lg font-bold text-green-900">
                <AcademicCapIcon class="mr-2 size-6" />
                Certifications
            </h2>
            <PrimaryButton
                v-if="isEditable"
                as="button"
                size="sm"
                @click="openModal()"
            >
                <PlusIcon class="size-5" />
                Ajouter
            </PrimaryButton>
        </div>

        <ul class="mt-4 space-y-3">
            <li
                v-for="cert in certifications"
                :key="cert.id"
                class="flex items-center justify-between rounded-xl border border-green-900/20 p-3 shadow-sm"
            >
                <div>
                    <p class="font-semibold text-green-900">{{ cert.name }}</p>
                    <p class="text-sm text-green-800">
                        {{ cert.institution }} ({{ cert.year }})
                    </p>
                </div>

                <div v-if="isEditable" class="flex items-center gap-3">
                    <PencilIcon
                        class="h-5 w-5 cursor-pointer text-green-800 transition hover:text-green-600"
                        @click="openModal(cert)"
                    />
                    <TrashIcon
                        class="h-5 w-5 cursor-pointer text-green-800 transition hover:text-red-500"
                        @click="requestDeleteCert(cert.id)"
                    />
                </div>
            </li>
        </ul>
        <Modal :show="showModal" max-width="md" @close="showModal = false">
            <div class="p-6">
                <h2 class="mb-4 text-lg font-bold">
                    {{ selectedCert ? 'Modifier' : 'Ajouter' }} une
                    certification
                </h2>
                <CertificationForm
                    :certification="selectedCert"
                    @submitted="handleSubmitted"
                    @cancel="showModal = false"
                />
            </div>
        </Modal>

        <ConfirmDialog
            :show="showConfirm"
            message="Voulez-vous vraiment supprimer cette certification ?"
            @cancel="cancelDelete"
            @confirm="confirmDelete"
        />
    </div>
</template>
