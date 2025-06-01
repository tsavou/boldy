<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { XMarkIcon, VideoCameraIcon } from '@heroicons/vue/24/solid';
import ConfirmDialog from '@/Components/ConfirmDialog.vue';
import VideoCard from '@/Components/VideoCard.vue';

defineProps({
    videos: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const showConfirm = ref(false);
const videoToDelete = ref(null);

const form = useForm({
    media: null,
    type: 'video',
});

const confirmDelete = () => {
    useForm().delete(route('freelance-medias.destroy', videoToDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            showConfirm.value = false;
            videoToDelete.value = null;
        },
    });
};

const cancelDelete = () => {
    showConfirm.value = false;
    videoToDelete.value = null;
};

const requestDelete = (id) => {
    videoToDelete.value = id;
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
        <div v-if="isEditable" class="mb-4 flex justify-end">
            <label
                class="shadow-xs inline-flex cursor-pointer gap-x-1.5 rounded-md border border-green-900 bg-green-900 px-2 py-1 text-sm font-bold text-orange-50 hover:border-green-900 hover:bg-orange-50 hover:text-green-900 hover:duration-300 hover:ease-in-out"
            >
                <VideoCameraIcon class="size-5" />
                Ajouter une vidéo
                <input
                    type="file"
                    accept="video/*"
                    class="hidden"
                    @change="handleFileChange"
                />
            </label>
        </div>

        <div class="gap-4">
            <div
                v-for="video in videos"
                :key="video.id"
                class="relative mb-4 break-inside-avoid"
            >
                <VideoCard :src="video.url" />
                <button
                    v-if="isEditable"
                    class="absolute right-1 top-1 rounded-full bg-red-600 p-1 text-white"
                    @click.prevent="requestDelete(video.id)"
                >
                    <XMarkIcon class="h-4 w-4" />
                </button>
            </div>
        </div>

        <ConfirmDialog
            :show="showConfirm"
            message="Supprimer cette vidéo ?"
            @cancel="cancelDelete"
            @confirm="confirmDelete"
        />
    </div>
</template>
