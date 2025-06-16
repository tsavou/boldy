<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import ProfileHeader from '@/Components/FreelanceProfile/ProfileHeader.vue';
import Bio from '@/Components/FreelanceProfile/Bio.vue';
import AlertBanner from '@/Components/AlertBanner.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/solid/index.js';
import { computed, ref } from 'vue';
import KeyInfos from '@/Components/FreelanceProfile/KeyInfos.vue';
import JobSelect from '@/Components/FreelanceProfile/JobSelect.vue';
import CertificationList from '@/Components/FreelanceProfile/Certifications/CertificationList.vue';
import SkillSelect from '@/Components/FreelanceProfile/SkillSelect.vue';
import ExperienceList from '@/Components/FreelanceProfile/Experiences/ExperienceList.vue';
import Links from '@/Components/FreelanceProfile/Links.vue';
import VideoGallery from '@/Components/FreelanceProfile/VideoGallery.vue';
import PhotoGallery from '@/Components/FreelanceProfile/PhotoGallery.vue';

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
    <Head :title="freelance.full_name">
        <meta
            name="description"
            :content="
                freelance.bio ||
                'Profil freelance de ' + freelance.full_name + ' sur Boldy'
            "
        />
    </Head>
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
        <section class="mx-auto my-4 max-w-6xl px-4">
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
                        class="flex flex-col gap-2 rounded-3xl bg-green-900 p-6 text-orange-50 shadow-md"
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
                        <CertificationList
                            :certifications="freelance.certifications"
                            :is-editable="isEditable"
                            @notify="handleNotification"
                        />
                    </div>

                    <!-- Liens externes -->
                    <div
                        class="rounded-3xl bg-orange-100 p-6 text-green-900 shadow"
                    >
                        <Links
                            :links="freelance.links"
                            :is-editable="isEditable"
                            @notify="handleNotification"
                        />
                    </div>

                    <!-- Photos -->
                    <PhotoGallery
                        :photos="photos"
                        :is-editable="isEditable"
                        @notify="handleNotification"
                    />
                </div>

                <!-- colonne de droite -->
                <div class="order-1 col-span-2 flex flex-col gap-4 md:order-2">
                    <!-- Présentation (bio) -->
                    <div
                        class="flex flex-col gap-3 rounded-3xl bg-lime-100 p-6 shadow-md"
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
                        class="flex flex-col gap-3 rounded-3xl bg-orange-100/50 p-6 shadow"
                    >
                        <SkillSelect
                            :skills="skills"
                            :freelance="freelance"
                            :is-editable="isEditable"
                            @notify="handleNotification"
                        />
                    </div>

                    <!-- Expériences -->
                    <div
                        class="flex flex-col gap-3 overflow-auto rounded-3xl bg-lime-50 p-6 shadow"
                    >
                        <ExperienceList
                            :experiences="freelance.experiences"
                            :is-editable="isEditable"
                            @notify="handleNotification"
                        />
                    </div>

                    <VideoGallery
                        :videos="videos"
                        :isEditable="isEditable"
                        @notify="handleNotification"
                    />
                </div>
            </div>
        </section>
    </Layout>
</template>
