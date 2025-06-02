<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const siretInput = ref(null);

const form = useForm({
    siret: '',
    identity_document: null,
});

const verify = () => {
    form.post(route('freelance.verify'), {
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
                Merci de renseigner votre numéro de SIRET ainsi qu'une pièce d'identité.
                Une fois validé, votre profil Boldy sera visible sur la plateforme.
            </p>
        </header>

        <form @submit.prevent="verify" class="mt-6 space-y-6">
            <div>
                <InputLabel for="siret" value="Numéro de SIRET" />
                <TextInput
                    id="siret"
                    ref="siretInput"
                    maxlength="14"
                    v-model="form.siret"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    @input="form.siret = form.siret.replace(/\D/g, '')"
                />
                <InputError :message="form.errors.siret" class="mt-2" />
            </div>

            <div>
                <InputLabel for="identity_document" value="Pièce d'identité (JPEG, PNG ou PDF)" />
                <input
                    id="identity_document"
                    type="file"
                    accept="image/jpeg, image/png, application/pdf"
                    @change="e => form.identity_document = e.target.files[0]"
                    class="mt-2 block w-full text-sm text-gray-700"
                    required
                />
                <InputError :message="form.errors.identity_document" class="mt-2" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Envoyer</PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
                        Demande envoyée !
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
