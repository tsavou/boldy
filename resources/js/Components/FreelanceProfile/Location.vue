<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
    MapPinIcon,
    PencilIcon,
    XMarkIcon,
    CheckCircleIcon,
} from '@heroicons/vue/24/solid';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    freelance: Object,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const isEditing = ref(false);

const form = useForm({
    location: props.freelance.location || '',
});

const startEditing = () => {
    isEditing.value = true;
};

const cancelEditing = () => {
    isEditing.value = false;
    form.location = props.freelance.location || '';
};

const submitLocation = () => {
    form.put(route('freelance.updateLocation', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            isEditing.value = false;
        },
    });
};
</script>

<template>
    <div class="flex items-center gap-2">


        <!-- Affichage de la localisation si présente -->
        <template v-if="freelance.location && !isEditing">
            <MapPinIcon class="h-4 w-4 text-gray-400" />
            <p class="text-sm text-gray-600">{{ freelance.location }}</p>
            <button
                v-if="isEditable"
                @click="startEditing"
                class="text-green-900 transition hover:text-green-700"
                title="Modifier"
            >
                <PencilIcon class="h-4 w-4" />
            </button>
        </template>

        <!-- Si pas de localisation et non editing -->
        <template v-else-if="!freelance.location && !isEditing && isEditable">
            <PrimaryButton
                type="button"
                as="button"
                size="sm"
                @click="startEditing"
            >
                <MapPinIcon class="h-4 w-4" />
                Ajouter une localisation
            </PrimaryButton>
        </template>

        <!-- Mode édition -->
        <template v-if="isEditing">
            <div class="flex items-center gap-2">
                <TextInput
                    v-model="form.location"
                    type="text"
                    placeholder="Paris"
                    class="text-sm"
                />
                <button
                    @click="submitLocation"
                    class="text-green-900 hover:text-green-700"
                    title="Valider"
                >
                    <CheckCircleIcon class="h-6 w-6" />
                </button>
                <button
                    @click="cancelEditing"
                    class="rounded-full bg-red-600 p-0.5 text-orange-100 hover:bg-red-500"
                    title="Annuler"
                >
                    <XMarkIcon class="h-4 w-4" />
                </button>
            </div>
            <InputError :message="form.errors.location" class="text-sm" />
        </template>
    </div>
</template>
