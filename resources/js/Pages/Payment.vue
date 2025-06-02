<script setup>
import PaymentForm from '@/Components/PaymentForm.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    mode: String,
    option: String,
});

const plansLabels = {
    premium_monthly: 'Abonnement Premium Mensuel',
    premium_yearly: 'Abonnement Premium Annuel',
    '7_days': 'Boost 7 jours',
    '14_days': 'Boost 14 jours',
    '30_days': 'Boost 30 jours',
};
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-20 max-w-xl p-8 xl:my-40">
            <h1 class="mb-4 text-2xl font-bold">
                Paiement {{ mode === 'boost' ? 'Boost' : 'Premium' }}
            </h1>

            <p class="mb-6 text-gray-600">
                Vous êtes sur le point d'acheter :
                <strong>{{ plansLabels[option] }}</strong>
            </p>

            <PaymentForm :mode="mode" :option="option" />
        </div>
    </AppLayout>
</template>
