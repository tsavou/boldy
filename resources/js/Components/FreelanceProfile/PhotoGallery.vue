<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { PlusIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';

defineProps({
    photos: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const showConfirm = ref(false);
const photoToDelete = ref(null);

const form = useForm({
    media: null,
    type: 'image',
});

const confirmDelete = () => {
    useForm().delete(route('freelance-medias.destroy', photoToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            showConfirm.value = false;
            photoToDelete.value = null;
        },
    });
};

const cancelDelete = () => {
    showConfirm.value = false;
    photoToDelete.value = null;
};

const requestDelete = (id) => {
    photoToDelete.value = id;
    showConfirm.value = true;
};

const handleFileChange = (e) => {
    form.media = e.target.files[0];
    form.post(route('freelance-medias.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            form.reset();
        },
    });
};
</script>

<template>
    <div>
        <div class="columns-2 gap-4">
            <div
                v-for="photo in photos"
                :key="photo.id"
                class="relative mb-4 break-inside-avoid"
            >
                <img
                    :src="photo.url"
                    alt="Photo"
                    class="w-full rounded-xl object-cover object-center shadow-lg"
                />
                <button
                    v-if="isEditable"
                    class="absolute right-1 top-1 rounded-full bg-red-600 p-1 text-white"
                    @click.prevent="requestDelete(photo.id)"
                >
                    <XMarkIcon class="h-4 w-4" />
                </button>
            </div>
        </div>

        <div v-if="isEditable" class="mt-4 flex justify-end">
            <label
                class="shadow-xs inline-flex cursor-pointer gap-x-1.5 rounded-md border border-green-900 bg-green-900 px-2 py-1 text-sm font-bold text-orange-50 hover:border-green-900 hover:bg-orange-50 hover:text-green-900 hover:duration-300 hover:ease-in-out"
            >
                <PlusIcon class="size-5" />
                Ajouter une photo
                <input
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="handleFileChange"
                />
            </label>
        </div>

        <ConfirmDialog
            :show="showConfirm"
            message="Supprimer cette photo ?"
            @cancel="cancelDelete"
            @confirm="confirmDelete"
        />
    </div>
</template>
