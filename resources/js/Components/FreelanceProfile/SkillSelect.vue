<script setup>
import MultiSelectInput from '@/Components/MultiSelectInput.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {
    CheckIcon,
    PencilIcon,
    XMarkIcon,
    WrenchScrewdriverIcon,
} from '@heroicons/vue/24/solid/index.js';

const props = defineProps({
    freelance: Object,
    skills: Array,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const editing = ref(false);

const form = useForm({
    skills: (props.freelance.skills || []).map((s) => s.id),
});

const handleEditing = () => {
    if (editing.value) {
        form.reset();
    }
    editing.value = !editing.value;
};

const saveSkills = () => {
    form.put(route('freelances.updateSkills', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            editing.value = false;
        },
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <h2 class="flex items-center text-lg font-bold text-green-900">
            <WrenchScrewdriverIcon class="mr-2 size-5" />
            Compétences
        </h2>
        <div class="flex gap-2">
            <PrimaryButton
                as="button"
                :color="editing ? 'secondary' : 'green'"
                size="sm"
                v-if="isEditable"
                @click="handleEditing"
            >
                <XMarkIcon v-if="editing" class="size-5" />
                <PencilIcon v-else class="size-5" />
                {{
                    editing
                        ? 'Annuler'
                        : freelance.skills.length === 0
                          ? 'Ajouter'
                          : 'Modifier'
                }}
            </PrimaryButton>
            <PrimaryButton
                v-if="editing"
                size="sm"
                color="green"
                @click="saveSkills"
                as="button"
            >
                <CheckIcon class="size-5" />
                Valider
            </PrimaryButton>


        </div>

    </div>

    <!-- Affichage simple -->
    <div v-if="!editing" class="flex flex-wrap gap-2">
        <span
            v-if="freelance.skills.length === 0"
            class="text-sm text-green-800"
        >
            Aucune compétence ajoutée.
        </span>
        <span
            v-for="skill in freelance.skills"
            :key="skill.id"
            class="inline-block truncate rounded-full border border-green-700 bg-green-800 px-3 py-1 text-sm font-medium text-lime-200"
        >
            {{ skill.name }}
        </span>
    </div>

    <!-- Formulaire d'édition -->
    <div v-if="editing" class="flex flex-col gap-3">
        <MultiSelectInput
            v-model="form.skills"
            :options="skills"
            label-key="name"
            value-key="id"
            placeholder="Sélectionner des compétences"
        />
    </div>
</template>
