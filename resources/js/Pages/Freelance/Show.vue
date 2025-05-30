<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import ProfileHeader from '@/Components/FreelanceProfile/ProfileHeader.vue';
import {
    PlusIcon,
    PencilIcon,
    LinkIcon,
    AcademicCapIcon,
} from '@heroicons/vue/24/solid';
import Bio from '@/Components/FreelanceProfile/Bio.vue';
import AlertBanner from '@/Components/AlertBanner.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/solid/index.js';
import { computed, ref } from 'vue';
import KeyInfos from '@/Components/FreelanceProfile/KeyInfos.vue';
import JobSelect from '@/Components/FreelanceProfile/JobSelect.vue';

const props = defineProps({
    freelance: Object,
    isEditable: Boolean,
    professions: Array,
    skills: Array,
    errors: Object,
});

const page = usePage();

const showNotification = ref(false);

const photos = computed(() => {
    return props.freelance.freelance_medias
        ? props.freelance.freelance_medias.filter(
              (media) => media.type === 'image',
          )
        : [];
});

const videos = computed(() => {
    return props.freelance.freelance_medias
        ? props.freelance.freelance_medias.filter(
              (media) => media.type === 'video',
          )
        : [];
});
const handleNotification = () => {
    showNotification.value = true;
    setTimeout(() => {
        showNotification.value = false;
    }, 3000);
};
</script>
<template>
    <Head :title="freelance.full_name" />
    <Layout>
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

        <ProfileHeader
            :freelance="freelance"
            :isEditable="isEditable"
            :errors="errors"
            @notify="handleNotification"
        />
        <section class="mx-auto mt-4 max-w-6xl px-4">
            <JobSelect
                :jobs="professions"
                :freelance="freelance"
                :is-editable="isEditable"
                @notify="handleNotification"
            />
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                <!-- colonne 1-->
                <div class="order-2 col-span-1 flex flex-col gap-4 md:order-1">
                    <!-- Infos clés -->
                    <div
                        class="flex flex-col gap-2 rounded-3xl bg-green-900 p-6 text-orange-50 shadow"
                    >
                        <KeyInfos
                            :freelance="freelance"
                            :is-editable="isEditable"
                            @notify="handleNotification"
                        />
                    </div>

                    <!-- Certifications -->
                    <div
                        class="flex flex-col gap-3 rounded-3xl bg-lime-50 p-6 shadow"
                    >
                        <div class="flex items-center justify-between">
                            <h2
                                class="flex items-center gap-2 text-lg font-bold text-green-900"
                            >
                                <AcademicCapIcon class="h-5 w-5" />
                                Certifications
                            </h2>
                            <button
                                v-if="isEditable"
                                class="flex items-center gap-1 text-sm text-green-900 hover:text-green-700"
                            >
                                <PlusIcon class="h-5 w-5" />
                                Ajouter
                            </button>
                        </div>
                        <ul class="text-sm text-green-800">
                            <li
                                v-for="cert in freelance.certifications"
                                :key="cert.id"
                            >
                                📜 {{ cert.name }} — {{ cert.institution }} ({{
                                    cert.year
                                }})
                            </li>
                        </ul>
                    </div>

                    <!-- Liens externes -->
                    <div
                        class="rounded-3xl bg-green-900 p-6 text-orange-50 shadow"
                    >
                        <h2 class="flex items-center gap-2 text-lg font-bold">
                            <LinkIcon class="h-5 w-5" />
                            Liens externes
                        </h2>
                        <ul class="mt-2 text-sm">
                            <li v-if="freelance.portfolio_url">
                                🌐
                                <a
                                    :href="freelance.portfolio_url"
                                    target="_blank"
                                    class="underline"
                                    >Portfolio</a
                                >
                            </li>
                            <li v-if="freelance.linkedin_url">
                                🔗
                                <a
                                    :href="freelance.linkedin_url"
                                    target="_blank"
                                    class="underline"
                                    >LinkedIn</a
                                >
                            </li>
                        </ul>
                    </div>

                    <!-- Photos -->
                    <div class="columns-2 gap-4">
                        <div
                            v-for="photo in photos"
                            :key="photo.id"
                            class="mb-4 break-inside-avoid"
                        >
                            <img
                                v-if="photo.type === 'image'"
                                :src="photo.url"
                                alt="Média"
                                class="w-full rounded-xl object-cover object-center shadow-lg"
                            />
                        </div>
                    </div>
                </div>

                <!-- colonne de droite -->
                <div class="order-1 col-span-2 flex flex-col gap-4 md:order-2">
                    <!-- Présentation (bio) -->
                    <div
                        class="flex flex-col gap-3 rounded-3xl border border-orange-100 bg-orange-100/50 p-6 shadow"
                    >
                        <Bio
                            :bio="freelance.bio"
                            :is-editable="isEditable"
                            :freelance-id="freelance.id"
                            @notify="handleNotification"
                        />
                    </div>

                    <!-- Compétences -->
                    <div
                        class="flex flex-col gap-3 rounded-3xl bg-orange-100 p-6 shadow"
                    >
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-green-900">
                                Compétences
                            </h2>
                            <button
                                v-if="isEditable"
                                class="text-green-900 hover:text-green-700"
                            >
                                <PencilIcon class="h-5 w-5" />
                            </button>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <span
                                v-for="skill in freelance.skills"
                                :key="skill.id"
                                class="rounded-full border border-green-700 bg-green-800 px-2 py-1 text-xs text-orange-50"
                            >
                                {{ skill.name }}
                            </span>
                        </div>
                    </div>

                    <!-- Expériences -->
                    <div
                        class="flex flex-col gap-3 overflow-auto rounded-3xl bg-orange-100 p-6 shadow"
                    >
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-bold text-green-900">
                                Expériences
                            </h2>
                            <button
                                v-if="isEditable"
                                class="flex items-center gap-1 text-sm text-green-900 hover:text-green-700"
                            >
                                <PlusIcon class="h-5 w-5" />
                                Ajouter
                            </button>
                        </div>
                        <div
                            v-for="exp in freelance.experiences"
                            :key="exp.id"
                            class="rounded-lg border border-lime-100 bg-white p-3 text-sm"
                        >
                            <p class="font-bold text-green-900">
                                {{ exp.title }}
                            </p>
                            <p class="text-gray-600">
                                {{ exp.company }} • {{ exp.start_date }} →
                                {{ exp.end_date }}
                            </p>
                            <p class="mt-1 text-xs text-green-800">
                                {{ exp.description }}
                            </p>
                        </div>
                    </div>

                    <div class="gap-4">
                        <div
                            v-for="video in videos"
                            :key="video.id"
                            class="mb-4 break-inside-avoid"
                        >
                            <iframe
                                :src="video.url"
                                title="Vidéo"
                                allowfullscreen
                                class="aspect-video w-full rounded-xl object-cover object-center shadow-lg md:h-[414px]"
                            ></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>
