<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ChevronRightIcon, ChevronLeftIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    links: {
        type: Array,
        required: true,
    },
});

const getLinks = computed(() => {
    const links = [...props.links];

    const firstItem = links.shift();
    const lastItem = links.pop();

    firstItem.icon = 'left';
    lastItem.icon = 'right';

    if (links.length <= 4) {
        return [firstItem, ...links, lastItem];
    } else {
        const firstTwo = links.slice(0, 2);
        const lastTwo = links.slice(-2);
        const activeLink = links.find((e) => e.active === true);
        const newLinks = [firstItem, ...firstTwo];
        const middleLinks = [];

        if (
            activeLink &&
            !firstTwo.includes(activeLink) &&
            !lastTwo.includes(activeLink)
        ) {
            middleLinks.push(activeLink);
        }

        if (links[links.length - 3] !== activeLink) {
            middleLinks.push({ url: null, label: '...', active: false });
        } else {
            middleLinks.unshift({ url: null, label: '...', active: false });
        }

        return [...newLinks, ...middleLinks, ...lastTwo, lastItem];
    }
});
</script>

<template>
    <nav
        class="shadow-xs relative z-0 inline-flex -space-x-px truncate rounded-md"
    >
        <div v-for="(link, key) in getLinks" :key="key">
            <!-- eslint-disable vue/no-v-text-v-html-on-component -->
            <Link
                preserve-scroll
                preserve-state
                :href="link.url ?? '#'"
                :class="[
                    'relative inline-flex select-none items-center border border-gray-300 px-4 py-2 text-sm text-gray-600 focus:z-10 focus:border-green-900 focus:outline-none focus:ring-green-900 focus:ring-offset-1 focus:ring-offset-white',
                    link.url ? 'cursor-pointer' : 'cursor-not-allowed',
                    {
                        'z-10 border-2 border-green-900 bg-green-50 font-bold text-green-900 hover:bg-green-100':
                            link.active,
                    },
                    { 'bg-white hover:bg-green-50': !link.active && link.url },
                    { 'bg-gray-100': !link.active && !link.url },
                    { 'rounded-l-md': key === 0 },
                    { 'rounded-r-md': key === getLinks.length - 1 },
                ]"
                pagination-action
            >
                <template v-if="link.icon === 'left'">
                    <ChevronLeftIcon class="size-5" aria-hidden="true" />
                </template>
                <template v-else-if="link.icon === 'right'">
                    <ChevronRightIcon class="size-5" aria-hidden="true" />
                </template>
                <template v-else>
                    <span v-html="link.label"></span>
                </template>
            </Link>
        </div>
    </nav>
</template>
