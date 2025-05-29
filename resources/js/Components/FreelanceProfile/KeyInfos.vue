<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { PencilIcon, CheckIcon } from '@heroicons/vue/24/solid';
import Toggle from '@/Components/Toggle.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon } from '@heroicons/vue/24/solid/index.js';
import Slider from '@vueform/slider';

const props = defineProps({
    freelance: Object,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const editing = ref(false);
const form = useForm({
    is_available: !!props.freelance.is_available,
    price_per_day: props.freelance.price_per_day,
});

const handleEditing = () => {
    if (editing.value) {
        form.reset();
    }
    editing.value = !editing.value;
};

const saveInfos = () => {
    form.put(route('freelance.updateInfos', props.freelance.id), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            editing.value = false;
        },
    });
};
</script>

<template>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold">Infos clés</h2>
        <PrimaryButton
            as="button"
            :color="editing ? 'white' : 'secondary'"
            size="sm"
            v-if="isEditable"
            @click="handleEditing"
        >
            <XMarkIcon v-if="editing" class="size-5" />
            <PencilIcon v-else class="size-5" />
            {{ editing ? 'Annuler' : 'Modifier' }}


        </PrimaryButton>
    </div>

    <div class="space-y-6">
        <p class="flex items-center">
            <Toggle v-if="editing" v-model="form.is_available" active-color="green" activeColor="bg-green-600" />
            <span
                :class="form.is_available ? 'bg-green-600' : 'bg-red-500'"
                class="rounded-full px-2 py-0.5 text-sm text-orange-50"
            >
                {{ form.is_available ? 'Disponible' : 'Indisponible' }}
            </span>
        </p>
        <p v-if="!editing">
            💶 <strong>{{ form.price_per_day }}€</strong> / jour
        </p>
        <div v-else class="flex items-center justify-between">
            <div class="slider--lime text-green-900">
                <label for="price" class="mr-2">Tarif :</label>
                <Slider
                    v-model="form.price_per_day"
                    :min="0"
                    :max="1500"
                    :step="5"
                    :format="(v) => `${Math.round(v)}€`"
                    class="w-48"
                />
            </div>
            <PrimaryButton
                :processing="form.processing"
                as="button"
                color="secondary"
                size="sm"
                @click="saveInfos"
                class="hover:border-orange-50"
            >
                <CheckIcon class="size-5" />
                Valider
            </PrimaryButton>
        </div>

        <p>
            🎖️ Niveau : <strong>{{ props.freelance.experience_level }}</strong>
        </p>
        <p>🕑 Expérience : {{ props.freelance.experience_in_years }} {{ props.freelance.experience_in_years > 1 ? 'ans' : 'an' }}</p>
        <p v-if="editing" class="mt-2 text-xs italic text-lime-200">
            Le niveau et les années d'expérience sont calculés automatiquement à
            partir de vos expériences.
        </p>
    </div>
</template>
<style
    src="../../../../node_modules/@vueform/slider/themes/default.css">


</style>
