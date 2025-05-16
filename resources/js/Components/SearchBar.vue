<script setup>
import {
    Combobox,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue';
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import { computed, ref, watch } from 'vue';

const props = defineProps({
    modelValue: Object,
    options: {
        type: Array,
        required: true,
    },
    icon: {
        default: () => MagnifyingGlassIcon,
    },
    placeholder: {
        type: String,
        default: 'Recherche...',
    },
});

const emit = defineEmits(['select']);

const query = ref('');

const filteredOptions = computed(() => {
    if (query.value === '') {
        return []
    }

    return  props.options.filter((option) => {
        if (typeof option === 'object') {
            console.log('object', option)
            return option.name
                .toLowerCase()
                .includes(query.value.toLowerCase());
        }
        console.log(option)
        return option.toLowerCase().includes(query.value.toLowerCase());
    })
    }
);

const onSelect = (option) => {
    emit('update:modelValue', option)
    emit('select', option);
    query.value = '';
};

//TODO: watch pour debug
//TODO: debug suppression de la valeur au clavier

</script>

<template>
    <Combobox as="div" :modelValue="modelValue" @update:modelValue="onSelect">
        <div class="relative grid grid-cols-1 ">
            <ComboboxInput
                class="rounded-md sm:rounded-none border border-gray-300 col-start-1 row-start-1 h-12 w-full pl-11 pr-4 text-base text-gray-900 outline-none placeholder:text-gray-400 sm:text-sm focus:border-green-900 focus:ring-1 focus:ring-green-900"
                :placeholder=placeholder
                :displayValue="(option) => option?.name || option"
                @change="query = $event.target.value"
                @blur="query = ''"
            />
            <component
                :is="icon"
                class="pointer-events-none col-start-1 row-start-1 ml-4 size-5 self-center text-gray-400"
                aria-hidden="true"
            />

        <ComboboxOptions
            v-if="filteredOptions.length > 0"
            static
            class="absolute z-10 w-full top-full mt-1 max-h-72 overflow-y-auto py-2 text-sm text-gray-800 bg-white border border-gray-300 rounded-md"
        >
            <ComboboxOption
                v-for="(option, index) in filteredOptions"
                :key="option.id || index"
                :value="option"
                as="template"
                v-slot="{ active }"
            >
                <li
                    :class="[
                        'cursor-default select-none px-4 py-2',
                        active && 'bg-green-900 text-white outline-none',
                    ]"
                >
                    <div>
                        <div>{{ option.name || option }}</div>
                        <div v-if="option.type" class="text-xs text-gray-500" :class="active && 'text-orange-50'">
                            {{ option.type }}
                        </div>
                    </div>
                </li>
            </ComboboxOption>
        </ComboboxOptions>
        </div>

<!--        <p
            v-if="query !== '' && filteredOptions.length === 0"
            class="p-4 text-sm text-gray-500"
        >
            No options found.
        </p>-->
    </Combobox>
</template>

<style scoped></style>
