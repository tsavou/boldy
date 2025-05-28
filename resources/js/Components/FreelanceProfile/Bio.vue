<script setup>
import { nextTick, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { PencilIcon, CheckIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    bio: String,
    isEditable: Boolean,
    freelanceId: Number,
});

const emit = defineEmits(['notify']);

const editing = ref(false);
const bioInput = ref(null);

const form = useForm({
    bio: bioInput.value,
});

const handleEditing = () => {
    if (editing.value) {
        form.bio = props.bio;
        editing.value = false;
    } else {
        editing.value = true;
        nextTick(() => {
            //initialise le contenu du div quand on passe en édition
            if (bioInput.value) {
                bioInput.value.innerText = props.bio || '';
                bioInput.value.focus();
            }
        });
    }
};

const handleInput = (e) => {
    form.bio = e.target.innerText;
};

const saveBio = () => {
    form.put(route('freelance.updateBio', props.freelanceId), {
        preserveScroll: true,
        onSuccess: () => {
            emit('notify');
            editing.value = false;
        }
    });
};
</script>

<template>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-bold text-green-900">À propos</h2>
        <PrimaryButton
            as="button"
            :color="editing ? 'secondary' : 'green'"
            size="sm"
            v-if="isEditable"
            @click="handleEditing"
        >
            <XMarkIcon v-if="editing" class="size-5" />
            <PencilIcon v-else class="size-5" />
            {{ editing ? 'Annuler' : 'Modifier' }}


        </PrimaryButton>
    </div>
    <div v-if="editing">
        <div class="relative">
            <div
                ref="bioInput"
                contenteditable="true"
                @input="handleInput"
                class="w-full min-h-32 max-h-60 overflow-auto whitespace-pre-wrap break-words bg-orange-50 rounded border border-green-900 p-2 text-sm text-green-900 focus:outline-none"
            ></div>
            <PrimaryButton
                :processing="form.processing"
                as="button"
                size="sm"
                @click="saveBio"
                class="absolute bottom-4 right-2 flex items-center gap-1 rounded bg-green-900 px-2 py-1 text-white hover:bg-green-700"
            >
                <CheckIcon class="h-4 w-4" />
                Valider
            </PrimaryButton>
        </div>
    </div>
    <p v-else class="text- text-green-900 whitespace-pre-line">
        {{ bio || 'Aucune biographie n\'a été ajoutée pour le moment.' }}
    </p>
</template>
