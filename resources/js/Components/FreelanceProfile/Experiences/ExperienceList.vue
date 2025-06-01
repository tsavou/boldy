<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
    BriefcaseIcon,
    PlusIcon,
    PencilIcon,
    TrashIcon,
} from '@heroicons/vue/24/solid';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import Modal from '@/Components/Modal.vue';
import ExperienceForm from '@/Components/FreelanceProfile/Experiences/ExperienceForm.vue';
import { formatDate } from '@/utils/formatters.js';

defineProps({
    experiences: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const showModal = ref(false);
const selectedExp = ref(null);
const showConfirm = ref(false);
const expToDelete = ref(null);

const openModal = (exp = null) => {
    selectedExp.value = exp;
    showModal.value = true;
};

const handleSubmitted = () => {
    showModal.value = false;
    notify();
};

const notify = () => {
    emit('notify');
};

const requestDeleteExp = (expId) => {
    expToDelete.value = expId;
    showConfirm.value = true;
};

const confirmDelete = () => {
    useForm().delete(route('experiences.destroy', expToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            notify();
            showConfirm.value = false;
            expToDelete.value = null;
        },
    });
};

const cancelDelete = () => {
    showConfirm.value = false;
    expToDelete.value = null;
};
</script>

<template>
    <div>
        <div class="flex items-center justify-between">
            <h2 class="flex items-center text-lg font-bold text-green-900">
                <BriefcaseIcon class="mr-2 size-6" />
                Expériences
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

        <div v-if="experiences.length === 0">
            <p class="mt-4 text-sm text-green-800">
                Aucune certification ajoutée.
            </p>
        </div>

        <ul class="mt-6 space-y-3">
            <li
                v-for="exp in experiences"
                :key="exp.id"
                class="flex justify-between rounded-xl border border-green-900/30 bg-orange-50/70 p-4 shadow-md"
            >
                <div class="flex max-w-[80%] flex-col gap-1">
                    <p class="text-md truncate font-semibold text-green-900">
                        {{ exp.title }}
                    </p>
                    <p class="text-sm font-medium text-gray-700">
                        {{ exp.company }} &bull;
                        <time :datetime="exp.start_date"
                            >{{ formatDate(exp.start_date) }}
                        </time>
                        →
                        <time :datetime="exp.end_date"
                            >{{
                                exp.end_date
                                    ? formatDate(exp.end_date)
                                    : "Aujourd'hui"
                            }}
                        </time>
                    </p>
                    <p
                        class="line-clamp-3 text-sm leading-relaxed text-green-800"
                    >
                        {{ exp.description }}
                    </p>
                </div>

                <div
                    v-if="isEditable"
                    class="flex items-center gap-3 text-green-800"
                >
                    <button
                        aria-label="Modifier expérience"
                        @click="openModal(exp)"
                        class="rounded-full p-1 transition hover:hover:text-green-600"
                    >
                        <PencilIcon class="h-5 w-5" />
                    </button>
                    <button
                        aria-label="Supprimer expérience"
                        @click="requestDeleteExp(exp.id)"
                        class="transition hover:text-red-500"
                    >
                        <TrashIcon class="h-5 w-5" />
                    </button>
                </div>
            </li>
        </ul>

        <Modal :show="showModal" @close="showModal = false">
            <div class="p-6">
                <h2 class="mb-4 text-lg font-bold">
                    {{ selectedExp ? 'Modifier' : 'Ajouter' }} une expérience
                </h2>
                <ExperienceForm
                    :experience="selectedExp"
                    @submitted="handleSubmitted"
                    @cancel="showModal = false"
                />
            </div>
        </Modal>

        <ConfirmDialog
            :show="showConfirm"
            message="Voulez-vous vraiment supprimer cette expérience ?"
            @cancel="cancelDelete"
            @confirm="confirmDelete"
        />
    </div>
</template>
