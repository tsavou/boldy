<script setup>
import MultiSelectInput from '@/Components/MultiSelectInput.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {
    CheckIcon,
    PencilIcon,
    XMarkIcon,
} from '@heroicons/vue/24/solid/index.js';

const props = defineProps({
    freelance: Object,
    jobs: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const editing = ref(false);

const form = useForm({
    professions: (props.freelance.professions || []).map((p) => p.id),
});

const handleEditing = () => {
    if (editing.value) {
        form.reset();
    }
    editing.value = !editing.value;
};

const saveJobs = () => {
    form.put(route('freelances.updateProfessions', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            editing.value = false;
        },
    });
};
</script>

<template>
    <div
        class="my-12 flex flex-col items-center justify-center gap-2 text-center"
    >
        <div
            v-if="!editing && freelance.professions.length > 0"
            class="flex items-center justify-center gap-2 text-center text-green-900"
        >
            <h2 class="text-2xl font-bold text-green-800">
                {{ freelance.professions.map((p) => p.name).join(' • ') }}
            </h2>
            <PencilIcon
                class="size-5 cursor-pointer hover:text-green-600"
                v-if="isEditable && !editing"
                @click="handleEditing"
            />
        </div>
        <!-- Bouton pour ajouter un métier si aucun et pas en édition -->
        <div
            v-if="!editing && freelance.professions.length === 0 && isEditable"
            class="my-6 text-center font-bold text-green-800"
        >
            <span @click="handleEditing" class="cursor-pointer"
                >Vous n'avez pas encore de métier ? Cliquez ici pour en ajouter
                un.</span
            >
        </div>

        <!-- Formulaire édition -->
        <div
            v-if="editing"
            class="flex w-full items-center justify-center gap-2 text-center"
        >
            <div class="w-full max-w-md">
                <MultiSelectInput
                    v-model="form.professions"
                    :options="jobs"
                    label-key="name"
                    value-key="id"
                    placeholder="Selectionner un ou plusieurs métiers"
                />
            </div>
            <div class="flex flex-col gap-2">
                <PrimaryButton
                    color="secondary"
                    size="sm"
                    class="flex gap-2 ring-1 ring-green-900"
                    @click="handleEditing"
                    as="button"
                >
                    <XMarkIcon class="size-5" />
                    Annuler
                </PrimaryButton>
                <PrimaryButton
                    size="sm"
                    color="green"
                    class="flex gap-2 ring-1 ring-green-900"
                    @click="saveJobs"
                    as="button"
                >
                    <CheckIcon class="size-5" />
                    Valider
                </PrimaryButton>
            </div>
        </div>
    </div>
</template>
