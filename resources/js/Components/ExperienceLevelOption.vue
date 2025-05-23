<script setup>

import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['update:modelValue']);

const selectedLevels = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

const levels = [
    { id: 1, name: 'Junior' },
    { id: 2, name: 'Intermédiaire' },
    { id: 3, name: 'Confirmé' },
    { id: 4, name: 'Expert' },
];
</script>

<template>
    <form class="space-y-4">
        <div
            v-for="level in levels"
            :key="level.id"
            class="flex gap-3"
        >
            <div class="flex h-5 shrink-0 items-center">
                <div class="group grid size-4 grid-cols-1">
                    <input
                        :id="`level-${level.id}`"
                        name="experience[]"
                        :value="level.name"
                        type="checkbox"
                        v-model="selectedLevels"
                        class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-green-900 checked:bg-green-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-900"
                    />
                    <svg
                        class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white"
                        viewBox="0 0 14 14"
                        fill="none"
                    >
                        <path
                            class="opacity-0 group-has-[:checked]:opacity-100"
                            d="M3 8L6 11L11 3.5"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>
            <label
                :for="`level-${level.id}`"
                class="whitespace-nowrap pr-6 text-sm font-medium text-gray-900"
            >{{ level.name }}</label
            >
        </div>
    </form>

</template>

<style scoped>

</style>
