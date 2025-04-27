<script setup>
import { computed } from 'vue';

const props = defineProps({
    as: {
        type: String,
        default: 'button',
    },
    size: {
        type: String,
        default: 'md',
        validator: value => ['xs', 'sm', 'md', 'lg', 'xl'].includes(value),
    },
    color: {
        type: String,
        default: 'green',
    },
    processing: {
        type: Boolean,
        default: false,
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    borderRadius: {
        type: String,
        default: 'md',
    },
});

const buttonColorClass = computed(() => {
    return {
        purple: 'border border-purple-600 bg-purple-600 hover:bg-purple-700 hover:border-purple-700 text-white',
        green: 'border border-green-900 bg-green-900 hover:bg-lime-300 hover:border-green-900 text-white hover:text-green-900',
        secondary: 'border border-green-900 bg-white hover:bg-lime-300 hover:border-green-900 text-green-900',
        white: 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700',
        red: 'border border-red-600 bg-red-600 hover:bg-red-400 hover:border-red-400 text-white',
        orange: 'border border-orange-500 bg-orange-500 hover:bg-orange-400 hover:border-orange-400 text-white',
        gray: 'border border-gray-100 bg-gray-100 hover:bg-gray-200 hover:border-gray-200 text-gray-700',
    }[props.color];
});

const processingClass = computed(() => {
    return {
        purple: 'text-white',
        green: 'text-white',
        white: 'text-gray-700',
        red: 'text-white',
        orange: 'text-white',
        gray: 'text-gray-700',
    }[props.color];
});

const processingSizeClass = computed(() => {
    return {
        xs: 'h-3 w-3 mr-0.5',
        sm: 'h-4 w-4 mr-2 -mb-0.5',
        md: 'h-4 w-4 mr-2 -mb-0.5',
        lg: 'h-4 w-4 mr-2 -mb-0.5',
        xl: 'h-4 w-4 mr-2 -mb-0.5',
    }[props.size];
});

const buttonSizeClass = computed(() => {
    if (props.as === 'icon') {
        return {
            xs: 'px-2 py-2',
            sm: 'px-2.5 py-2.5',
            md: 'px-3 py-3',
            lg: 'px-3.5 py-3.5',
            xl: 'px-4 py-4',
        }[props.size];
    }

    return {
        xs: 'px-2 py-1 text-xs',
        sm: 'px-2 py-1 text-sm',
        md: 'px-2.5 py-1.5 text-sm',
        lg: 'px-3 py-2 text-sm',
        xl: 'px-3.5 py-2.5 text-sm',
    }[props.size];
});

const buttonAs = computed(() => {
    return {
        button: 'button',
        icon: 'button',
        a: 'a',
        Link: 'Link',
    }[props.as];
});

const borderRadiusClass = computed(() => {
    return {
        sm: 'rounded-sm',
        md: 'rounded-md',
        lg: 'rounded-lg',
        full: 'rounded-full',
    }[props.borderRadius];
});
</script>

<template>
    <component
        :is="buttonAs"
        :disabled="(processing || disabled)"
        :class="[buttonSizeClass, buttonColorClass, borderRadiusClass, 'flex items-center justify-center font-bold shadow-xs disabled:opacity-80 hover:bg-gray-100 disabled:cursor-not-allowed gap-x-1.5 cursor-pointer']"
        :aria-disabled="disabled"
    >
        <span v-if="processing" :class="[processingClass, processingSizeClass, 'inline-block']">
            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
            </svg>
        </span>
        <slot />
    </component>
</template>
