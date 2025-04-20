<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    freelances: Object,
});
</script>

<template>
    <Head title="Freelances Catalog" />
    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div v-for="freelance in freelances" :key="freelance.id">
            {{ freelance.user.first_name }}
            {{ freelance.user.name }}

            <a :href="route('freelance.show', freelance.id)">Voir le profil</a>
        </div>
    </Layout>
</template>
