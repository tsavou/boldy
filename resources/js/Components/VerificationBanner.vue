<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AlertBanner from '@/Components/AlertBanner.vue';
import AlertBannerStack from '@/Components/AlertBannerStack.vue';

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
    <AlertBannerStack>
        <AlertBanner v-if="!isEmailVerified">
            <template #title>Email non vérifié</template>
            <p v-if="!verificationLinkSent">
                Veuillez vérifier votre boîte de réception pour le lien de
                vérification.
            </p>

            <p v-else>
                Un nouveau lien de vérification a été envoyé à l'adresse e-mail
                que vous avez fournie lors de l'inscription.
            </p>
            <button
                @click="submit"
                :class="{
                    'disabled cursor-not-allowed opacity-25': form.processing,
                }"
                class="font-bold underline"
            >
                Renvoyer l'email de vérification
            </button>
            <span aria-hidden="true">&rarr;</span>
        </AlertBanner>
        <AlertBanner v-if="!isFreelanceVerified">
            <template #title>Profil non vérifié</template>
            <p>
                Pour être visible publiquement sur la plateforme, merci de
                renseigner votre <span class="font-bold">SIRET</span> et votre
                <span class="font-bold">pièce d'identité</span>.
            </p>
            <Link :href="route('profile.edit')" class="font-bold underline">
                Cliquez ici
            </Link>
            <span aria-hidden="true">&rarr;</span>
        </AlertBanner>
    </AlertBannerStack>
</template>
