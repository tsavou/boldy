<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    certification: Object, // null ou certif à modifier
});

const emit = defineEmits(['submitted', 'cancel']);

const form = useForm({
    name: '',
    institution: '',
    year: '',
});

const currentYear = new Date().getFullYear();
// Générer une liste d'années de 1950 à l'année actuelle
const years = Array.from({ length: 75 }, (_, i) => currentYear - i);

// Si on modifie une certification, on pré-remplit le formulaire
watch(
    () => props.certification,
    (cert) => {
        if (cert) {
            form.name = cert.name;
            form.institution = cert.institution;
            form.year = cert.year;
        } else {
            form.reset();
            form.year = currentYear;
        }
    },
    { immediate: true },
);

const submit = () => {
    if (props.certification) {
        form.put(route('certifications.update', props.certification.id), {
            preserveScroll: true,
            onSuccess: () => emit('submitted'),
        });
    } else {
        form.post(route('certifications.store'), {
            preserveScroll: true,
            onSuccess: () => emit('submitted'),
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="flex flex-col gap-3">
        <div>
            <InputLabel for="name" value="Nom" />
            <TextInput
                id="name"
                v-model="form.name"
                type="text"
                placeholder="Certification, formation, diplôme..."
                class="mt-1 block w-full"
            />
            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
            <div class="flex items-end justify-between">
                <InputLabel for="institution" value="Institution" />
                <span class="text-xs text-gray-500" id="institution-optional"
                    >Optionnel</span
                >
            </div>
            <TextInput
                id="institution"
                v-model="form.institution"
                type="text"
                placeholder="Institution"
                class="mt-1 block w-full"
            />
            <InputError class="mt-2" :message="form.errors.institution" />
        </div>

        <div>
            <InputLabel for="year" value="Année d'obtention" />
            <select
                id="year"
                v-model="form.year"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-900 focus:ring-green-900"
            >
                <option v-for="year in years" :key="year" :value="year">
                    {{ year }}
                </option>
            </select>
            <InputError class="mt-2" :message="form.errors.year" />
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <PrimaryButton
                as="button"
                color="red"
                size="lg"
                @click="emit('cancel')"
            >
                Annuler
            </PrimaryButton>
            <PrimaryButton as="button" size="lg">
                {{ certification ? 'Valider' : 'Ajouter' }}
            </PrimaryButton>
        </div>
    </form>
</template>
