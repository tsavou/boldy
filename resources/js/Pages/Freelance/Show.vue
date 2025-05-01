<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import {
    XMarkIcon,
    CheckCircleIcon,
    CameraIcon,
    MapPinIcon,
} from '@heroicons/vue/24/solid';
import AlertBannerStack from '@/Components/AlertBannerStack.vue';
import AlertBanner from '@/Components/AlertBanner.vue';

defineProps({
    freelance: Object,
    isEditable: Boolean,
    errors: Object,
});

const page = usePage();

const imagesForm = useForm({
    avatar: null,
    cover: null,
});

const showNotification = ref(true);
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
    imagesForm.post(route('profile.updateImages'), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification.value = true;
            resetCoverImage();
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        },
    });
};

const submitAvatarImage = () => {
    imagesForm.post(route('profile.updateImages'), {
        preserveScroll: true,
        onSuccess: () => {
            showNotification.value = true;
            resetAvatarImage();
            setTimeout(() => {
                showNotification.value = false;
            }, 3000);
        },
    });
};
</script>

<template>
    <Head :title="freelance.user.first_name + '  ' + freelance.user.name" />

    <Layout>
        <div>
            <AlertBanner
                v-show="showNotification && page.props.flash.success"
                fixed
                position="top"
            >
                <template #icon>
                    <CheckCircleIcon class="h-5 w-5" />
                </template>
                <template #title>
                    {{ page.props.flash.success }}
                </template>
            </AlertBanner>
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

            <div class="group relative bg-white">
                <div class="relative flex">
                    <img
                        :src="
                            coverImageSrc ||
                            freelance.cover_picture ||
                            '/img/default_cover.jpg'
                        "
                        :alt="`Image de couverture de ${freelance.user.first_name} ${freelance.user.name}`"
                        class="h-[200px] w-full object-cover"
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
                        <div
                            v-else
                            class="absolute right-2 top-2 flex gap-2 p-2"
                        >
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

                <div class="flex">
                    <div
                        class="group/avatar relative -mt-[64px] ml-[48px] flex h-[128px] w-[128px] items-center justify-center rounded-full"
                    >
                        <img
                            :src="
                                avatarImageSrc ||
                                freelance.profile_picture ||
                                '/img/default_avatar.jpg'
                            "
                            :alt="`${freelance.slug} avatar`"
                            class="h-full w-full rounded-full object-cover"
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

                    <div class="p-4">
                        <h2 class="text-lg font-bold">
                            {{ freelance.user.first_name }}
                            {{ freelance.user.name }}
                        </h2>
                        <div class="flex items-center">
                            <MapPinIcon class="h-4 w-4 text-gray-400" />
                            <p class="text-gray-400">
                                {{ freelance.location }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
