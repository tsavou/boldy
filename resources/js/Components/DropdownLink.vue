<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    href: {
        type: String,
    },
    active: {
        type: Boolean,
    },
});

const classes = computed(() =>
    props.active
        ? 'block w-full px-4 py-2 text-start text-sm leading-5 text-green-900 transition duration-150 ease-in-out bg-lime-300 focus:outline-none'
        : 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-50 transition duration-150 ease-in-out hover:bg-lime-300 hover:text-green-900 focus:text-green-900 focus:bg-lime-300 focus:outline-none',
);
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
