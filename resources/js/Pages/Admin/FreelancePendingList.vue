<script setup>
import { router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { IdentificationIcon } from '@heroicons/vue/24/solid';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

defineProps({
    freelances: Array,
});

const selectedDocument = ref(null);

const approve = (id) => {
    router.post(route('admin.freelance.approve', id));
};
</script>

<template>
    <AppLayout title="Validation des freelances">
        <template #header>
            <h1 class="text-xl font-semibold leading-tight text-gray-800">
                Freelances en attente de validation
            </h1>
        </template>
        <section class="mx-auto max-w-4xl py-12">
            <div v-if="freelances.length === 0">Aucun freelance à valider.</div>

            <table v-else class="w-full table-auto bg-orange-100">
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
                            <button
                                @click="
                                    selectedDocument = f.identity_document_path
                                "
                                class="text-green-900"
                            >
                                <IdentificationIcon
                                    class="inline-block h-6 w-6"
                                />
                                Voir
                            </button>
                        </td>
                        <td class="border px-4 py-2">
                            <PrimaryButton @click="approve(f.id)"
                                >Valider
                            </PrimaryButton>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </AppLayout>

    <Modal
        :show="!!selectedDocument"
        @close="selectedDocument = null"
        max-width="2xl"
    >
        <img
            v-if="selectedDocument"
            :src="selectedDocument"
            alt="Document d'identité"
            class="mx-auto h-auto max-w-full"
        />
    </Modal>
</template>
