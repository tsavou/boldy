<script setup>
import { computed, ref } from 'vue';
import { XMarkIcon, InformationCircleIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    bgColor: { type: String, default: 'bg-lime-300' },
    textColor: { type: String, default: 'text-green-900' },
    fixed: { type: Boolean, default: false },
    position: { type: String, default: 'bottom' },
});

const emit = defineEmits(['close']);

const visible = ref(true);

const positionClass = computed(() => {
    if (!props.fixed) return '';
    return props.position === 'top'
        ? 'fixed inset-x-0 top-12 sm:px-6 pt-5 lg:px-8 pointer-events-none z-50'
        : 'fixed inset-x-0 bottom-0 sm:px-6 sm:pb-5 lg:px-8 pointer-events-none z-50';
});
const close = () => {
    visible.value = false;
    emit('close');
};
</script>

<template>
    <transition name="fade" mode="out-in">
        <div v-if="visible" role="banner" :class="positionClass">
            <div
                :class="[
                    'pointer-events-auto mx-auto flex w-full items-center justify-between gap-x-4 rounded-md px-4 py-3 sm:gap-x-6 sm:rounded-xl sm:px-6 sm:py-4',
                    bgColor,
                    textColor,
                ]"
            >
                <div
                    class="flex flex-wrap items-center gap-2 text-sm/6 leading-5"
                >
                    <slot name="icon">
                        <InformationCircleIcon
                            class="size-5"
                            aria-hidden="true"
                        />
                        <span class="sr-only">Information</span>
                    </slot>
                    <strong class="font-semibold">
                        <slot name="title"></slot>
                    </strong>
                    <slot />
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
