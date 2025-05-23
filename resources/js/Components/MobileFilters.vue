<script setup>
import AdvancedFilters from '@/Components/AdvancedFilters.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline/index.js';
import {
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';

defineProps({
    opened: {
        type: Boolean,
        default: false,
    },
    hasActiveFilters: Boolean,
    filters: Object,
});

const emit = defineEmits(['close']);

const close = () => {
    emit('close');
};
</script>

<template>
    <TransitionRoot as="template" :show="opened">
        <Dialog class="relative z-50 sm:hidden" @close="close">
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 z-40 flex">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="translate-x-full"
                >
                    <DialogPanel
                        class="relative ml-auto flex size-full max-w-xs flex-col overflow-y-auto bg-orange-100 py-4 pb-12 shadow-xl"
                    >
                        <div class="flex items-center justify-between px-4">
                            <h2 class="text-lg font-medium text-gray-900">
                                Filtres avancés
                            </h2>
                            <button
                                type="button"
                                class="-mr-2 flex size-10 items-center justify-center rounded-md p-2 text-gray-400"
                                @click="close"
                            >
                                <span class="sr-only">Close menu</span>
                                <XMarkIcon class="size-6" aria-hidden="true" />
                            </button>
                        </div>

                        <!-- Filters -->
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>
