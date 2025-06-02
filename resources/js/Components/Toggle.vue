<script setup>
import { Switch, SwitchGroup, SwitchLabel } from '@headlessui/vue';

defineProps({
    modelValue: Boolean,
    label: String,
    activeColor: {
        type: String,
        default: 'bg-lime-400',
    },
    inactiveColor: {
        type: String,
        default: 'bg-gray-300',
    },
    textClass: {
        type: String,
        default: 'text-sm font-medium text-green-900',
    },
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <SwitchGroup as="div" class="flex items-center gap-2">
        <Switch
            :modelValue="modelValue"
            @update:modelValue="emit('update:modelValue', $event)"
            :class="[
                modelValue ? activeColor : inactiveColor,
                'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out',
            ]"
        >
            <span
                aria-hidden="true"
                :class="[
                    modelValue ? 'translate-x-5' : 'translate-x-0',
                    'pointer-events-none inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                ]"
            />
        </Switch>
        <SwitchLabel as="span" :class="textClass">
            {{ label }}
        </SwitchLabel>
    </SwitchGroup>
</template>
