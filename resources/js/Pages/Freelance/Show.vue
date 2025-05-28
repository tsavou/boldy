<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import ProfileHeader from '@/Components/FreelanceProfile/ProfileHeader.vue';

defineProps({
    freelance: Object,
    isEditable: Boolean,
    errors: Object,
});
</script>

<template>
    <Head :title="freelance.full_name" />

    <Layout>
        <ProfileHeader
            :freelance="freelance"
            :isEditable="isEditable"
            :errors="errors"
        />
    </Layout>
</template>
