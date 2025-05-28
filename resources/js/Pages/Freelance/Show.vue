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
import { ref } from 'vue';

defineProps({
    freelance: Object,
    isEditable: Boolean,
    errors: Object,
});

const page = usePage();

const showNotification = ref(false);
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
            <h2 class="mb-8 text-center text-lg font-bold text-green-800">
                {{ freelance.professions.map((p) => p.name).join(' • ') }}
            </h2>
            <div class="flex grid-rows-12 flex-col gap-4 sm:grid sm:grid-cols-3">
                <!-- Infos clés -->
                <div
                    class="row-span-2 flex flex-col gap-2 rounded-3xl bg-green-900 p-6 text-orange-50 shadow"
                >
                    <h2 class="text-lg font-bold">Infos clés</h2>
                    <p class="flex items-center gap-2">
                        <span
                            :class="
                                freelance.is_available
                                    ? 'bg-green-600'
                                    : 'bg-red-500'
                            "
                            class="rounded-full px-2 py-0.5 text-xs text-white"
                        >
                            {{
                                freelance.is_available
                                    ? 'Disponible'
                                    : 'Indisponible'
                            }}
                        </span>
                    </p>
                    <p>
                        💶 À partir de
                        <strong>{{ freelance.price_per_day }}€</strong> / jour
                    </p>
                    <p>
                        🎖️ Niveau :
                        <strong>{{ freelance.experience_level }}</strong>
                    </p>
                    <p>
                        🕑 Expérience : {{ freelance.experience_in_years }} ans
                    </p>
                </div>

                <!-- Présentation (bio) -->
                <div
                    class="col-span-2 row-span-2 flex flex-col gap-3 rounded-3xl bg-orange-100 p-6 shadow"
                >
                    <Bio
                        :bio="freelance.bio"
                        :is-editable="isEditable"
                        :freelance-id="freelance.id"
                        @notify="handleNotification"
                    />
                </div>

                <!-- Certifications -->
                <div
                    class="row-span-2 flex flex-col gap-3 rounded-3xl bg-lime-50 p-6 shadow"
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

                <!-- Compétences -->
                <div
                    class="col-span-2 row-span-2 flex flex-col gap-3 rounded-3xl bg-orange-100 p-6 shadow"
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

                <!-- Liens externes -->
                <div
                    class="row-span-1 rounded-3xl bg-green-900 p-6 text-orange-50 shadow"
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

                <!-- Expériences -->
                <div
                    class="col-span-2 row-span-4 flex flex-col gap-3 overflow-auto rounded-3xl bg-orange-100 p-6 shadow"
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
                        <p class="font-bold text-green-900">{{ exp.title }}</p>
                        <p class="text-gray-600">
                            {{ exp.company }} • {{ exp.start_date }} →
                            {{ exp.end_date }}
                        </p>
                        <p class="mt-1 text-xs text-green-800">
                            {{ exp.description }}
                        </p>
                    </div>
                </div>

                <!-- Médias -->
                <!--  TODO: Ajouter une modale pour afficher les médias en grand -->

                <div
                    v-if="freelance.freelance_medias.length > 0"
                    v-for="media in freelance.freelance_medias"
                    :key="media.id"
                    class="col-span-1 row-span-3"
                >
                    <img
                        :src="media.url"
                        alt="Média"
                        class="h-full w-full rounded-xl object-cover object-center shadow-lg"
                    />
                </div>
            </div>
        </section>

        <!--<section class="max-w-5xl mx-auto">
            <div
                class="flex h-screen w-full flex-col items-center justify-center rounded-lg p-6"
            >
                <div class="grid h-full w-full grid-cols-1 sm:grid-cols-3 grid-rows-6 gap-4">
                    <div class="col-span-2 row-span-3 rounded-3xl bg-orange-400">
                    </div>
                    <div class="row-span-4 rounded-3xl bg-orange-400">
                    </div>
                    <div class="row-span-3 rounded-3xl bg-orange-400">
                    </div>
                    <div class="row-span-3 rounded-3xl bg-orange-400">
                    </div>
                    <div class="row-span-2 rounded-3xl bg-orange-400">
                    </div>
                </div>
            </div>
        </section>-->
    </Layout>
</template>
