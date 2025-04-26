<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-green-900 text-start text-base font-medium text-green-900 bg-lime-300 focus:outline-none focus:text-green-900 focus:bg-lime-300 focus:border-green-900 transition duration-150 ease-in-out'
        : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-50 hover:text-gray-800 hover:bg-gray-50 hover:border-lime-300 focus:outline-none focus:text-green-900 focus:bg-lime-300 focus:border-green-900 transition duration-150 ease-in-out',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
