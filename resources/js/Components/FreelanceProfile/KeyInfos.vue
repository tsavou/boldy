<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
    PencilIcon,
    CheckIcon,
    XMarkIcon,
    Squares2X2Icon,
} from '@heroicons/vue/24/solid';
import Toggle from '@/Components/Toggle.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Slider from '@vueform/slider';
import { formatExperience } from '@/utils/formatters.js';

const props = defineProps({
    freelance: Object,
    isEditable: Boolean,
});

const emit = defineEmits(['notify']);

const editing = ref(false);
const form = useForm({
    is_available: !!props.freelance.is_available,
    price_per_day: props.freelance.price_per_day || 0,
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
    <div class="mb-6 flex items-center justify-between">
        <h2 class="flex items-center text-lg font-bold">
            <Squares2X2Icon class="mr-2 size-6" />
            Infos clés
        </h2>
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

    <div class="grid grid-cols-2 gap-4">
        <!--Disponibilité-->
        <div
            class="flex flex-col items-center justify-center gap-2 rounded-xl bg-green-800/50 p-4"
        >
            <span
                :class="
                    form.is_available
                        ? 'bg-emerald-100 fill-emerald-500 text-emerald-800 ring-emerald-800'
                        : 'bg-rose-100 fill-rose-500 text-rose-800 ring-red-900'
                "
                class="inline-flex items-center gap-x-1.5 rounded-full px-2 py-0.5 text-sm font-medium ring-1 ring-inset"
            >
                {{ form.is_available ? 'Disponible' : 'Indisponible' }}
            </span>
            <Toggle
                v-if="editing"
                v-model="form.is_available"
                active-color="green"
                activeColor="bg-green-600"
            />
        </div>

        <!--Tarif-->
        <div
            class="flex flex-col gap-2 rounded-xl bg-green-800/50 p-4"
            v-if="!editing"
        >
            <span class="text-xs text-lime-200">Tarif indicatif</span>
            <span class="text-center text-lg font-bold"
                >{{ form.price_per_day }}€ / jour</span
            >
        </div>
        <div v-else class="flex flex-col gap-2 rounded-xl bg-green-800/50 p-4">
            <label for="price_per_day" class="text-xs text-lime-200"
                >Tarif indicatif</label
            >
            <div class="slider--lime">
                <Slider
                    v-model="form.price_per_day"
                    tooltipPosition="bottom"
                    :min="0"
                    :max="1500"
                    :step="5"
                    :format="(v) => `${Math.round(v)}€`"
                    class="w-32"
                />
            </div>
        </div>

        <div
            v-if="editing"
            class="col-span-2 flex items-center justify-between gap-2 rounded-xl bg-green-800/50 p-2 text-xs italic text-lime-200"
        >
            <p>
                Le niveau et les années d'expérience sont calculés
                automatiquement à partir de vos expériences.
            </p>
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

        <div class="flex flex-col gap-2 rounded-xl bg-green-800/50 p-4">
            <span class="text-xs text-lime-200">Expérience</span>
            <span class="text-center text-lg font-bold">
                {{ formatExperience(freelance.experience_in_years) }}
            </span>
        </div>

        <div
            class="flex items-center justify-center rounded-xl bg-green-800/50 p-4"
        >
            <span class="text-md text-center font-bold text-lime-300">
                {{ props.freelance.experience_level }}
            </span>
        </div>
    </div>
</template>
<style
    src="../../../../node_modules/@vueform/slider/themes/default.css"
></style>
