<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    freelance: Object,
    isEditable: Boolean,
});
</script>

<template>
    <Layout>
        <Head title="Show" />

        {{ freelance }}
    </Layout>
</template>
