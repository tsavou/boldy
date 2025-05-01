<script setup>
import { ref } from 'vue';
import { XMarkIcon, InformationCircleIcon } from '@heroicons/vue/24/solid';

defineProps({
    bgColor: { type: String, default: 'bg-lime-300' },
    textColor: { type: String, default: 'text-green-900' },
    fixed: { type: Boolean, default: false },
});

const emit = defineEmits(['close']);

const visible = ref(true);

const close = () => {
    visible.value = false;
    emit('close');
};
</script>

<template>
    <transition name="fade" mode="out-in">
        <div
            v-if="visible"
            role="banner"
            :class="[
                fixed
                    ? 'pointer-events-none fixed inset-x-0 bottom-0 sm:px-6 sm:pb-5 lg:px-8'
                    : '',
            ]"
        >
            <div
                :class="[
                    'pointer-events-auto flex items-center justify-between gap-x-6 px-6 py-2.5 sm:rounded-xl sm:py-3 sm:pl-4 sm:pr-3.5',
                    bgColor,
                    textColor,
                ]"
            >
                <div class="flex items-center gap-2 text-sm/6">
                    <InformationCircleIcon class="size-5" aria-hidden="true" />
                    <strong class="font-semibold">
                        <slot name="title">Attention</slot>
                    </strong>
                    <slot />
                    <span aria-hidden="true">&rarr;</span>
                </div>
                <button
                    type="button"
                    @click="close"
                    class="-m-3 flex-none p-3 focus-visible:outline-offset-[-4px]"
                >
                    <span class="sr-only">Fermer</span>
                    <XMarkIcon class="size-5" aria-hidden="true" />
                </button>
            </div>
        </div>
    </transition>
</template>
<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
