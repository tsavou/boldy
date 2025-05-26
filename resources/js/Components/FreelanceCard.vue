<template>
    <Link
        :href="route('freelance.show', freelance.slug)"
        class="group relative block w-80 max-w-full rounded-lg bg-green-900 pt-6 text-center text-orange-50 shadow-lg transition-transform duration-200 hover:scale-105"
    >
        <span
            v-if="freelance.is_boosted"
            class="group/boost absolute left-4 top-4"
        >
            <img src="/img/logo.svg" alt="Logo" class="h-6 w-6" />

            <span
                class="absolute -top-10 left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-green-800 px-2 py-1 text-xs text-orange-50 opacity-0 transition-opacity group-hover/boost:opacity-100"
            >
                Bolder Premium
            </span>
        </span>



        <span
            v-if="freelance.is_boosted"
            class="group/boost absolute right-4 top-4 rounded bg-lime-300 p-1"
        >
            <BoltIcon class="size-4 text-green-800" />
            <span
                class="absolute -top-10 left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-green-800 px-2 py-1 text-xs text-orange-50 opacity-0 transition-opacity group-hover/boost:opacity-100"
            >
                Boosté - ce freelance est mis en avant !
            </span>
        </span>

        <img
            class="mx-auto mb-4 h-28 w-28 rounded-full border-4 border-lime-300 object-cover shadow transition duration-200 group-hover:scale-110"
            :src="freelance.profile_picture || '/img/default_avatar.jpg'"
            :alt="freelance.full_name"
        />

        <div class="flex items-center justify-center gap-x-3">
            <h3 class="text-xl font-semibold">{{ freelance.first_name }}</h3>
            <div class="flex items-center gap-1 text-sm text-gray-400">
                <MapPinIcon class="h-4 w-4" />
                <span>{{ freelance.location }}</span>
            </div>
        </div>

        <p
            class="mt-2 px-4 text-center text-sm font-medium leading-5 text-lime-400"
        >
            {{ freelance.professions.map((p) => p.name).join(' • ') }}
        </p>

        <!-- Experience & Tarif -->
        <div class="mt-4 flex justify-center gap-2">
            <span
                class="rounded border border-orange-50 bg-green-900 px-2 py-1 text-xs"
            >
                {{ freelance.experience_level }}
            </span>
            <span
                class="rounded border border-orange-50 bg-green-900 px-2 py-1 text-xs"
            >
                {{ freelance.price_per_day }}€ / jour
            </span>
        </div>
        <!-- Skills -->

        <div class="my-4 flex flex-wrap justify-center gap-2 max-h-16 overflow-hidden">
            <span
                v-for="skill in freelance.skills"
                :key="skill.id"
                class="inline-block truncate rounded-full border border-green-700 bg-green-800 px-2 py-1 text-xs"
            >
                {{ skill.name }}
            </span>
        </div>
    </Link>
</template>

<script setup>
import { MapPinIcon } from '@heroicons/vue/24/outline';
import { BoltIcon } from '@heroicons/vue/24/solid';
import { Link } from '@inertiajs/vue3';

defineProps({
    freelance: {
        type: Object,
        required: true,
    },
});
</script>
