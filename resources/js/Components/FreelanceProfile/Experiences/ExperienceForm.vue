<script setup>
import { watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    experience: Object,
});

const emit = defineEmits(['submitted', 'cancel']);

const form = useForm({
    title: '',
    company: '',
    start_date: '',
    end_date: '',
    description: '',
});

watch(
    () => props.experience,
    (exp) => {
        if (exp) {
            form.title = exp.title;
            form.company = exp.company;
            form.start_date = exp.start_date;
            form.end_date = exp.end_date;
            form.description = exp.description;
        } else {
            form.reset();
        }
    },
    { immediate: true },
);

const submit = () => {
    if (props.experience) {
        form.put(route('experiences.update', props.experience.id), {
            preserveScroll: true,
            onSuccess: () => emit('submitted'),
        });
    } else {
        form.post(route('experiences.store'), {
            preserveScroll: true,
            onSuccess: () => emit('submitted'),
        });
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="flex flex-col gap-3">
        <div>
            <InputLabel for="title" value="Poste / Titre" />
            <TextInput
                id="title"
                v-model="form.title"
                type="text"
                class="mt-1 block w-full"
            />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
            <InputLabel for="company" value="Entreprise" />
            <TextInput
                id="company"
                v-model="form.company"
                type="text"
                class="mt-1 block w-full"
            />
            <InputError class="mt-2" :message="form.errors.company" />
        </div>

        <div class="flex gap-3">
            <div class="w-1/2">
                <InputLabel for="start_date" value="Date de début" />
                <TextInput
                    id="start_date"
                    v-model="form.start_date"
                    type="month"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.start_date" />
            </div>
            <div class="w-1/2">
                <InputLabel for="end_date" value="Date de fin (facultatif)" />
                <TextInput
                    id="end_date"
                    v-model="form.end_date"
                    type="month"
                    class="mt-1 block w-full"
                />
                <InputError class="mt-2" :message="form.errors.end_date" />
            </div>
        </div>

        <div>
            <InputLabel for="description" value="Description" />
            <textarea
                id="description"
                v-model="form.description"
                rows="3"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-900 focus:ring focus:ring-green-800 focus:ring-opacity-50"
            />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div class="mt-4 flex justify-end gap-2">
            <PrimaryButton
                as="button"
                type="button"
                color="red"
                size="lg"
                @click="emit('cancel')"
            >
                Annuler
            </PrimaryButton>
            <PrimaryButton as="button" size="lg">
                {{ experience ? 'Valider' : 'Ajouter' }}
            </PrimaryButton>
        </div>
    </form>
</template>
