<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import {
    PencilIcon,
    XMarkIcon,
    PlusIcon,
    FolderIcon,
} from '@heroicons/vue/24/solid';
import { GlobeAltIcon } from '@heroicons/vue/24/outline';

defineProps({
    links: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const showModal = ref(false);
const editingLink = ref(null);
const showConfirm = ref(false);
const linkToDelete = ref(null);

const form = useForm({
    type: '',
    url: '',
});

const linkTypes = [
    { value: 'portfolio', label: 'Portfolio' },
    { value: 'linkedin', label: 'LinkedIn' },
    { value: 'twitter', label: 'Twitter' },
    { value: 'facebook', label: 'Facebook' },
    { value: 'github', label: 'GitHub' },
    { value: 'instagram', label: 'Instagram' },
    { value: 'youtube', label: 'YouTube' },
    { value: 'tiktok', label: 'TikTok' },
    { value: 'behance', label: 'Behance' },
    { value: 'dribble', label: 'Dribbble' },
    { value: 'pinterest', label: 'Pinterest' },
    { value: 'threads', label: 'Threads' },
];

const openModal = (link = null) => {
    editingLink.value = link;
    if (link) {
        form.type = link.type;
        form.url = link.url;
    } else {
        form.reset();
    }
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const handleSubmit = () => {
    if (editingLink.value) {
        form.put(route('freelance-links.update', editingLink.value.id), {
            preserveScroll: true,
            onSuccess: () => {
                emit('notify');
                closeModal();
            },
        });
    } else {
        form.post(route('freelance-links.store'), {
            preserveScroll: true,
            onSuccess: () => {
                emit('notify');
                closeModal();
            },
        });
    }
};

const requestDeleteLink = (linkId) => {
    linkToDelete.value = linkId;
    showConfirm.value = true;
};

const confirmDelete = () => {
    useForm().delete(route('freelance-links.destroy', linkToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            showConfirm.value = false;
            linkToDelete.value = null;
        },
    });
};

const cancelDelete = () => {
    showConfirm.value = false;
    linkToDelete.value = null;
};
</script>

<template>
    <div>
        <div class="mb-4 flex items-center justify-between">
            <h2 class="flex items-center text-lg font-bold text-green-900">
                <GlobeAltIcon class="mr-2 size-6" />
                Réseaux
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

        <div v-if="links.length" class="flex flex-wrap items-center gap-3">
            <a
                v-for="link in links"
                :key="link.id"
                :href="link.url"
                target="_blank"
                rel="noopener noreferrer"
                class="group relative"
            >
                <template v-if="link.type === 'portfolio'">
                    <div
                        class="flex size-10 items-center justify-center rounded-full border-2 border-green-900 bg-green-900 text-xs font-bold text-orange-100 transition hover:scale-110"
                    >
                        <FolderIcon class="size-6" />
                    </div>
                </template>
                <template v-else>
                    <img
                        :src="`/img/socials/${link.type}.svg`"
                        :alt="link.type"
                        class="size-10 transition hover:scale-110"
                    />
                </template>
                <div
                    v-if="isEditable"
                    class="absolute inset-0 flex items-center justify-center"
                >
                    <button
                        type="button"
                        class="absolute -right-0 top-0 -translate-y-1/3 translate-x-1/3 rounded-full bg-red-600 p-0.5 text-orange-100 hover:bg-red-500"
                        @click.prevent="requestDeleteLink(link.id)"
                    >
                        <XMarkIcon class="size-3" />
                    </button>
                    <button
                        type="button"
                        class="absolute bottom-0 right-0 translate-x-1/3 translate-y-1/3 rounded-full bg-orange-50 p-0.5 text-green-900 hover:bg-green-900 hover:text-orange-100"
                        @click.prevent="openModal(link)"
                    >
                        <PencilIcon class="h-3 w-3" />
                    </button>
                </div>
            </a>
        </div>

        <div v-else class="text-sm italic text-gray-600">
            Aucun lien ajouté pour l’instant.
            <span v-if="isEditable">
                Ajoute tes réseaux ou ton portfolio pour booster ton profil !
            </span>
        </div>

        <Modal :show="showModal" @close="closeModal">
            <form @submit.prevent="handleSubmit" class="space-y-4 p-4">
                <h2 class="text-lg font-bold text-green-900">
                    {{ editingLink ? 'Modifier' : 'Ajouter' }} un lien
                </h2>

                <div>
                    <InputLabel for="type" value="Type de lien" />
                    <select
                        id="type"
                        v-model="form.type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-900 focus:ring-green-900"
                    >
                        <option disabled value="">-- Sélectionner --</option>
                        <option
                            v-for="lt in linkTypes"
                            :key="lt.value"
                            :value="lt.value"
                        >
                            {{ lt.label }}
                        </option>
                    </select>
                    <InputError :message="form.errors.type" class="mt-2" />
                </div>

                <div>
                    <InputLabel for="url" value="URL" />
                    <TextInput
                        id="url"
                        v-model="form.url"
                        type="url"
                        class="mt-1 block w-full"
                        placeholder="https://..."
                    />
                    <InputError :message="form.errors.url" class="mt-2" />
                </div>

                <div class="flex justify-end gap-2">
                    <PrimaryButton
                        type="button"
                        color="red"
                        @click="closeModal"
                    >
                        Annuler
                    </PrimaryButton>
                    <PrimaryButton type="submit">
                        {{ editingLink ? 'Valider' : 'Ajouter' }}
                    </PrimaryButton>
                </div>
            </form>
        </Modal>

        <ConfirmDialog
            :show="showConfirm"
            message="Voulez-vous vraiment supprimer ce lien ?"
            @cancel="cancelDelete"
            @confirm="confirmDelete"
        />
    </div>
</template>
