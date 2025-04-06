<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    isEmailVerified: {
        type: Boolean,
        required: true,
    },
    isFreelanceVerified: {
        type: Boolean,
        required: true,
    },
});

const verificationLinkSent = ref(false);

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
    verificationLinkSent.value = true;
};
</script>

<template>
    <div
        v-if="!isEmailVerified || !isFreelanceVerified"
        class="border-l-4 border-yellow-500 bg-yellow-100 p-4 text-yellow-800"
        role="alert"
    >
        <p class="font-bold">Attention</p>

        <div v-if="!isEmailVerified" class="flex items-center">
            <div class="mr-4">
                <p v-if="!verificationLinkSent">
                    Votre email n'est pas vérifié. Veuillez vérifier votre boîte
                    de réception pour le lien de vérification.
                </p>

                <p v-else>
                    Un nouveau lien de vérification a été envoyé à l'adresse
                    e-mail que vous avez fournie lors de l'inscription.
                </p>
            </div>
            <form @submit.prevent="submit">
                <div class="flex items-center justify-between">
                    <button
                        :class="{
                            'disabled cursor-not-allowed opacity-25':
                                form.processing,
                        }"
                        class="font-bold underline"
                    >
                        Renvoyer l'email de vérification
                    </button>
                </div>
            </form>
        </div>

        <p v-if="!isFreelanceVerified">
            Pour être visible publiquement sur la plateforme, votre profil freelance doit être vérifié.
            <Link :href="route('profile.edit')" class="font-bold underline"
                > Cliquez ici
            </Link>
            pour renseigner votre <span class="font-bold">SIRET</span> et
            votre <span class="font-bold">pièce d'identité</span>.
        </p>
    </div>
</template>
