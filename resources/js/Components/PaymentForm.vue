<script setup>
import { ref, onMounted } from 'vue';
import { loadStripe } from '@stripe/stripe-js';
import axios from 'axios';

const props = defineProps({
    mode: String, // 'boost' ou 'premium'
    option: String, // '7_days' | 'premium_monthly' etc.
});

const stripePublicKey = import.meta.env.VITE_STRIPE_PUBLIC_KEY;
const stripe = ref(null);
const cardElement = ref(null);
const loading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

onMounted(async () => {
    const stripeInstance = await loadStripe(stripePublicKey);
    const elements = stripeInstance.elements();
    const card = elements.create('card');
    card.mount('#card-element');
    stripe.value = stripeInstance;
    cardElement.value = card;

    // Reset erreur à chaque changement de carte
    card.on('change', (event) => {
        errorMessage.value = event.error ? event.error.message : '';
    });
});

const handleSubmit = async () => {
    errorMessage.value = '';
    successMessage.value = '';
    loading.value = true;

    // Création du PaymentMethod
    const { paymentMethod, error } = await stripe.value.createPaymentMethod({
        type: 'card',
        card: cardElement.value,
    });

    if (error) {
        errorMessage.value = error.message;
        loading.value = false;
        return;
    }

    // Préparer la charge à envoyer
    const payload = {
        payment_method: paymentMethod.id,
    };

    if (props.mode === 'boost') {
        payload.boost_duration = props.option;
    } else if (props.mode === 'premium') {
        payload.plan = props.option;
    }

    const endpoint =
        props.mode === 'boost'
            ? '/api/purchase/boost'
            : '/api/purchase/premium';

    try {
        const response = await axios.post(endpoint, payload);
        successMessage.value = 'Paiement validé ✅';
        console.log(response.data);
        // Reset carte après paiement réussi
        cardElement.value.clear();
    } catch (e) {
        errorMessage.value =
            e.response?.data?.message || 'Erreur lors du paiement.';
        console.error(e);
    } finally {
        loading.value = false;
    }
};
</script>

<template>
    <form
        @submit.prevent="handleSubmit"
        class="mx-auto max-w-md rounded border p-4"
    >
        <div id="card-element" class="mb-4 rounded border p-2"></div>

        <p v-if="errorMessage" class="mb-4 text-red-600">{{ errorMessage }}</p>
        <p v-if="successMessage" class="mb-4 text-green-600">
            {{ successMessage }}
        </p>

        <button
            type="submit"
            class="flex w-full items-center justify-center gap-2 rounded bg-green-900 py-2 font-semibold text-white disabled:cursor-not-allowed disabled:opacity-50"
            :disabled="loading"
        >
            <span
                v-if="loading"
                class="spinner-border h-5 w-5 animate-spin rounded-full border-2 border-white border-t-transparent"
            ></span>
            Payer
        </button>
    </form>
</template>

<style scoped>
.spinner-border {
    border-style: solid;
}
</style>
