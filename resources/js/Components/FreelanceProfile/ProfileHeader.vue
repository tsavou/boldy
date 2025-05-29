<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    XMarkIcon,
    CheckCircleIcon,
    CameraIcon,
    MapPinIcon,
    PencilIcon,
} from '@heroicons/vue/24/solid';
import AlertBanner from '@/Components/AlertBanner.vue';
import { EnvelopeIcon } from '@heroicons/vue/24/solid/index.js';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    freelance: Object,
    isEditable: Boolean,
    errors: Object,
});

const emit = defineEmits(['notify']);

const imagesForm = useForm({
    avatar: null,
    cover: null,
});

const coverImageSrc = ref('');
const avatarImageSrc = ref('');

const onCoverChange = (event) => {
    imagesForm.cover = event.target.files[0];
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            coverImageSrc.value = reader.result;
        };
        reader.readAsDataURL(imagesForm.cover);
    }
};

const onAvatarChange = (event) => {
    imagesForm.avatar = event.target.files[0];
    if (imagesForm.avatar) {
        const reader = new FileReader();
        reader.onload = () => {
            avatarImageSrc.value = reader.result;
        };
        reader.readAsDataURL(imagesForm.avatar);
    }
};

const resetCoverImage = () => {
    imagesForm.cover = null;
    coverImageSrc.value = null;
};

const resetAvatarImage = () => {
    imagesForm.avatar = null;
    avatarImageSrc.value = null;
};

const submitCoverImage = () => {
    imagesForm.post(route('freelance.updateImages', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            resetCoverImage();
        },
    });
};

const submitAvatarImage = () => {
    imagesForm.post(route('freelance.updateImages', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            resetAvatarImage();
        },
    });
};
</script>

<template>
    <div>
        <AlertBanner
            v-if="errors.cover"
            fixed
            position="top"
            bg-color="bg-red-400"
            text-color="text-white"
        >
            <template #title>
                {{ errors.cover }}
            </template>
        </AlertBanner>

        <div class="group relative bg-orange-50 text-green-900 shadow-md">
            <div class="relative flex">
                <img
                    :src="
                        coverImageSrc ||
                        freelance.cover_picture ||
                        '/img/default_cover.jpg'
                    "
                    :alt="`Image de couverture de ${freelance.full_name}`"
                    class="h-52 w-full object-cover"
                />
                <div v-if="isEditable">
                    <button
                        v-if="!coverImageSrc"
                        class="absolute bottom-0 left-0 right-0 top-0 flex items-center justify-center bg-black/50 text-gray-200 opacity-0 transition-opacity hover:opacity-100"
                    >
                        <CameraIcon class="h-8 w-8" />

                        <input
                            type="file"
                            accept="image/jpeg, image/png, image/jpg, image/webp, image/gif"
                            class="absolute bottom-0 left-0 right-0 top-0 cursor-pointer opacity-0"
                            @change="onCoverChange"
                        />
                    </button>
                    <div v-else class="absolute right-2 top-2 flex gap-2 p-2">
                        <button
                            @click="resetCoverImage"
                            class="flex items-center rounded bg-gray-50 px-2 py-1 text-xs text-gray-800 hover:bg-gray-200"
                        >
                            <XMarkIcon class="mr-2 h-3 w-3" />
                            Annuler
                        </button>
                        <button
                            @click="submitCoverImage"
                            class="flex items-center rounded bg-green-900 px-2 py-1 text-xs text-lime-300 hover:bg-lime-300 hover:text-green-900"
                        >
                            <CheckCircleIcon class="mr-2 h-3 w-3" />
                            Valider
                        </button>
                    </div>
                </div>
            </div>

            <div class="mx-auto flex max-w-6xl px-4 sm:px-6 lg:px-8">
                <div
                    class="group/avatar relative -mt-16 flex size-24 items-center justify-center sm:size-32"
                >
                    <img
                        :src="
                            avatarImageSrc ||
                            freelance.profile_picture ||
                            '/img/default_avatar.jpg'
                        "
                        :alt="`${freelance.full_name} avatar`"
                        class="h-full w-full rounded-full object-cover ring-2 ring-green-700"
                    />
                    <div v-if="isEditable">
                        <button
                            v-if="!avatarImageSrc"
                            class="absolute bottom-0 left-0 right-0 top-0 flex items-center justify-center rounded-full bg-black/50 text-gray-200 opacity-0 group-hover/avatar:opacity-100"
                        >
                            <CameraIcon class="h-8 w-8" />

                            <input
                                type="file"
                                accept="image/jpeg, image/png, image/jpg, image/webp, image/gif"
                                class="absolute bottom-0 left-0 right-0 top-0 cursor-pointer opacity-0"
                                @change="onAvatarChange"
                            />
                        </button>
                        <div v-else class="flex flex-col gap-1">
                            <button
                                @click="resetAvatarImage"
                                class="absolute bottom-0 right-1 flex h-7 w-7 items-center justify-center rounded-full bg-red-500/80 text-white"
                            >
                                <XMarkIcon class="h-5 w-5" />
                            </button>
                            <button
                                @click="submitAvatarImage"
                                class="absolute right-1 top-0 flex h-7 w-7 items-center justify-center rounded-full bg-emerald-500/80 text-white"
                            >
                                <CheckCircleIcon class="h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-2 sm:p-4">
                    <div class="flex items-center gap-2">
                        <h1 class="text-md font-bold sm:text-lg">
                            {{ freelance.full_name }}
                        </h1>
                        <span class="group/premium relative">
                            <img
                                src="/img/logo.svg"
                                alt="Logo"
                                class="size-4 rounded border border-green-800 bg-green-900"
                            />
                            <span
                                class="absolute left-20 top-1/2 -translate-x-1/2 -translate-y-1/2 whitespace-nowrap rounded bg-green-800 px-2 py-1 text-xs text-orange-50 opacity-0 transition-opacity group-hover/premium:opacity-100"
                            >
                                Bolder Premium
                            </span>
                        </span>
                    </div>
                    <div class="flex items-center">
                        <MapPinIcon class="h-4 w-4 text-gray-400" />
                        <p class="text-sm text-gray-400 sm:text-base">
                            {{ freelance.location }}
                        </p>
                    </div>
                </div>
                <div
                    class="flex min-w-0 flex-1 items-center justify-end space-x-6 pb-1"
                >
<!--                    &lt;!&ndash;      TODO: Ajouter la route pour modifier le profil du freelance             &ndash;&gt;
                    <PrimaryButton v-if="isEditable" as="button">
                        <PencilIcon class="-ml-0.5 size-4" aria-hidden="true" />
                        <span class="text-xs sm:text-sm">Éditer</span>
                    </PrimaryButton>-->
                    <PrimaryButton
                        v-if="!isEditable"
                        as="a"
                        :href="`mailto:${freelance.user.email}`"
                    >
                        <EnvelopeIcon
                            class="-ml-0.5 mr-1 size-5"
                            aria-hidden="true"
                        />
                        <span class="text-xs sm:text-sm">Contacter</span>
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
