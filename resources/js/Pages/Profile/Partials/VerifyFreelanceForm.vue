<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    siret: '',
});

//faire une une requete pour vérifier le siret -> dans le back controller avce class qui vérifie le siret existe via appel api https://api.insee.fr/api-sirene/3.11/siret/{siret}
const verify = () => {
    form.put(route(''), {
        preserveScroll: true,
        onError: () => {
            if (form.errors.siret) {
                form.reset('siret');
                siretInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Vérifiez votre profil Freelance
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Merci de renseigner votre numéro de SIRET ainsi qu'une pièce d'identité pour valider votre statut de freelance.
                Une fois validé, vous profil boldy sera visible sur la plateforme.
            </p>
        </header>

        <form @submit.prevent="verify" class="mt-6 space-y-6">
            <div>
                <InputLabel for="siret" value="SIRET" />

                <TextInput
                    id="siret"
                    ref="siretInput"
                    v-model="form.siret"
                    type="text"
                    class="mt-1 block w-full"
                />

                <InputError
                    :message="form.errors.siret"
                    class="mt-2"
                />
            </div>

            <div>
                <InputLabel for="identity" value="Pièce d'identité" />

                ajouter un systeme d evrif de l'identitté avec stripe identity
                <a href="https://docs.stripe.com/identity/verify-identity-documents?platform=web&type=modal">https://docs.stripe.com/identity/verify-identity-documents?platform=web&type=modal</a>
                <br>
                <a href="https://stripe.com/en-fr/identity">https://stripe.com/en-fr/identity</a>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
