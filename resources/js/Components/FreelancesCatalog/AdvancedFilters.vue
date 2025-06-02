<script setup>
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue';
import { ArrowPathIcon } from '@heroicons/vue/24/outline/index.js';
import Slider from '@vueform/slider';
import { ChevronDownIcon } from '@heroicons/vue/20/solid/index.js';
import { computed } from 'vue';
import ExperienceLevelOption from '@/Components/FreelancesCatalog/ExperienceLevelOption.vue';
import Toggle from '@/Components/Toggle.vue';

const props = defineProps({
    filters: Object,
    showClearButton: Boolean,
});

const emit = defineEmits(['update:filters', 'clearFilters']);

const filters = computed({
    get: () => props.filters,
    set: (value) => emit('update:filters', value),
});

const clearAllFilters = () => {
    emit('clearFilters');
};
</script>

<template>
    <div class="flex flex-col gap-8 md:flex-row md:items-center md:gap-12">
        <h3 class="mb-4 hidden text-sm font-medium text-gray-500 xl:block">
            Filtres avancés :
        </h3>

        <!-- Availability -->
        <Toggle
            v-model="filters.available"
            label="Disponible"
            activeColor="bg-green-900"
            inactiveColor="bg-gray-200"
        />

        <!-- Price Range -->

        <div class="flex w-48 flex-col space-y-2">
            <label class="block text-sm font-medium text-gray-700"
                >Tarif indicatif (/jour)</label
            >

            <Slider
                v-model="filters.priceRange"
                :min="0"
                :max="1500"
                :step="10"
                showTooltip="drag"
                tooltipPosition="top"
                :merge="500"
                :format="(v) => `${Math.round(v)}€`"
            />
            <div class="flex justify-between text-sm text-gray-500">
                <span>{{ filters.priceRange[0] }}€</span>
                <span>{{ filters.priceRange[1] }}€</span>
            </div>
        </div>

        <!-- Experience Level -->
        <div class="flex w-48 flex-col space-y-2">
            <label class="block text-sm font-medium text-gray-700"
                >Années d'expérience</label
            >

            <Slider
                v-model="filters.experienceRange"
                :min="0"
                :max="10"
                :step="1"
                :merge="2"
                showTooltip="drag"
            />

            <div class="flex justify-between text-sm text-gray-500">
                <span>{{ filters.experienceRange[0] }}</span>
                <span>{{
                    filters.experienceRange[1] < 10
                        ? filters.experienceRange[1]
                        : '10+'
                }}</span>
            </div>
        </div>

        <!-- Experience Level Desktop -->
        <PopoverGroup class="hidden md:flex md:items-baseline md:space-x-8">
            <Popover as="div" class="relative inline-block text-left">
                <div>
                    <PopoverButton
                        class="group inline-flex items-center justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                    >
                        <span>Niveau d'expérience</span>
                        <span
                            v-if="filters.level.length > 0"
                            class="ml-1.5 rounded bg-green-900 px-1.5 py-0.5 text-xs font-semibold text-white"
                        >
                            {{ filters.level.length }}
                        </span>
                        <ChevronDownIcon
                            class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500"
                            aria-hidden="true"
                        />
                    </PopoverButton>
                </div>

                <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                >
                    <PopoverPanel
                        class="absolute z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black/5 focus:outline-none"
                    >
                        <ExperienceLevelOption v-model="filters.level" />
                    </PopoverPanel>
                </transition>
            </Popover>
        </PopoverGroup>
        <div
            class="block space-y-4 text-sm font-medium text-gray-700 md:hidden"
        >
            <label>Niveau d'expérience</label>
            <ExperienceLevelOption v-model="filters.level" />
        </div>

        <button
            v-if="showClearButton"
            type="button"
            class="order-first text-sm text-gray-500 hover:underline md:order-last"
            @click="clearAllFilters"
        >
            <ArrowPathIcon class="inline size-4" aria-hidden="true" />
            Tout effacer
        </button>
    </div>
</template>
<style
    src="../../../../node_modules/@vueform/slider/themes/default.css"
></style>
