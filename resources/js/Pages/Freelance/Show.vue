<script setup>
import Layout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    freelance: Object,
});
</script>

<template>
    <Layout>
        <Head title="Show" />

        {{freelance}}
    </Layout>
</template>
