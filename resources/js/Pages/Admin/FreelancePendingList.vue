<script setup>
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { IdentificationIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    freelances: Array
});

const approve = (id) => {
    router.post(route('admin.freelance.approve', id));
};
</script>

<template>
    <AppLayout title="Validation des freelances">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Freelances en attente de validation
            </h1>
        </template>
        <section class="max-w-4xl mx-auto py-12">


            <div v-if="freelances.length === 0">Aucun freelance à valider.</div>

            <table v-else class="table-auto w-full bg-orange-100">
                <thead>
                <tr>
                    <th class="border px-4 py-2">Nom</th>
                    <th class="border px-4 py-2">SIRET</th>
                    <th class="border px-4 py-2">Pièce</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="f in freelances" :key="f.id">
                    <td class="border px-4 py-2">{{ f.full_name }}</td>
                    <td class="border px-4 py-2">{{ f.siret }}</td>
                    <td class="border px-4 py-2">
                        <a :href="f.identity_document_path" target="_blank"
                           class="text-green-900">
                            <IdentificationIcon class="w-6 h-6 inline-block"/>
                            Voir
                        </a>
                    </td>
                    <td class="border px-4 py-2">
                        <PrimaryButton @click="approve(f.id)">Valider</PrimaryButton>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>
    </AppLayout>
</template>
