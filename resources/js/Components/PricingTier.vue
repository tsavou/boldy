<template>
    <div
        :class="[
            tier.mostPopular ? 'ring-2 ring-green-900 scale-105' : 'ring-1 ring-gray-400',
            'rounded-3xl p-8 xl:p-10',
        ]"
    >
        <div class="flex items-center justify-between gap-x-4">
            <h3
                :id="tier.id"
                :class="[
                    tier.mostPopular ? 'text-green-900' : 'text-gray-900',
                    'text-lg font-semibold',
                ]"
            >
                {{ tier.name }}
            </h3>
            <p
                v-if="tier.mostPopular"
                class="rounded-full bg-green-900/10 px-2.5 py-1 text-xs font-semibold text-green-900"
            >
                Le plus populaire
            </p>
        </div>

        <p class="mt-4 whitespace-pre-line text-sm text-gray-600">
            {{ tier.description }}
        </p>

        <!-- Radio group pour choisir la fréquence -->
        <div v-show="selectedFrequency" class="mt-6 flex justify-center">
            <fieldset aria-label="Payment frequency">
                <RadioGroup
                    v-model="selectedFrequency"
                    class="flex gap-x-1 rounded-full p-1 text-center text-xs font-semibold ring-1 ring-inset ring-gray-200"
                >
                    <RadioGroupOption
                        v-for="option in tier.priceFrequency"
                        :key="option.frequency"
                        :value="option"
                        v-slot="{ checked }"
                    >
                        <div
                            :class="[
                                checked
                                    ? 'bg-green-900 text-white'
                                    : 'text-gray-600',
                                'cursor-pointer rounded-full px-2.5 py-1',
                            ]"
                        >
                            {{ option.frequency }}
                        </div>
                    </RadioGroupOption>
                </RadioGroup>
            </fieldset>
        </div>

        <!-- Prix et fréquences -->
        <div v-if="tier.priceFrequency" class="mt-6">
            <p class="flex items-baseline gap-x-1">
                <span class="text-4xl font-semibold text-gray-900">{{
                    selectedFrequency.price
                }}</span>
                <span class="text-sm font-semibold text-gray-600"
                    >/ {{ formattedFrequency }}</span
                >
            </p>
        </div>
        <p v-else class="mt-6 text-4xl font-semibold text-gray-900">Gratuit</p>

        <!-- CTA button -->
        <a
            :href="tier.href"
            :aria-describedby="tier.id"
            :class="[
                tier.mostPopular
                    ? 'bg-green-900 text-orange-50 shadow-sm hover:bg-green-700'
                    : 'text-green-900 ring-1 ring-inset ring-green-900 hover:bg-green-900 hover:text-orange-50',
                'mt-6 block rounded-md px-3 py-2 text-center text-sm font-semibold',
            ]"
        >
            {{ tier.cta }}
        </a>

        <!-- Features -->
        <ul role="list" class="mt-8 space-y-3 text-sm text-gray-600 xl:mt-10">
            <li
                v-for="feature in tier.features"
                :key="feature"
                class="flex gap-x-3"
            >
                <CheckIcon
                    class="h-6 w-5 flex-none text-green-900"
                    aria-hidden="true"
                    v-if="feature !== 'Shooting photos' || selectedFrequency?.frequency === 'Annuel'"
                />
                {{ feature !== 'Shooting photos' ? feature : selectedFrequency.frequency === 'Annuel' ? 'Shooting photos' : '' }}
            </li>
        </ul>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { RadioGroup, RadioGroupOption } from '@headlessui/vue';
import { CheckIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    tier: Object,
});

const selectedFrequency = ref(
    props.tier.priceFrequency ? props.tier.priceFrequency[0] : null,
);

const formattedFrequency = computed(() => {
    switch (selectedFrequency.value.frequency) {
        case 'Mensuel':
            return 'mois';
        case 'Annuel':
            return 'an';
        default:
            return selectedFrequency.value.frequency;
    }
});
</script>
