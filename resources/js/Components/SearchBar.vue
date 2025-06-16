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
    modelValue: [Object, String, null],
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

const emit = defineEmits(['select', 'update:modelValue', 'update:query']);

const query = ref('');

const filteredOptions = computed(() => {
    if (query.value === '') {
        return [];
    }

    return props.options.filter((option) => {
        if (typeof option === 'object') {
            return option.name
                .toLowerCase()
                .includes(query.value.toLowerCase());
        }
        return option.toLowerCase().includes(query.value.toLowerCase());
    });
});

const onSelect = (option) => {
    emit('update:modelValue', option);
    emit('select', option);
    query.value = '';
};

watch(query, (value) => {
    emit('update:query', value);
});
</script>

<template>
    <Combobox
        as="div"
        :modelValue="modelValue"
        @update:modelValue="onSelect"
        nullable
    >
        <div class="relative grid grid-cols-1">
            <ComboboxInput
                class="col-start-1 row-start-1 h-12 w-full rounded-md border border-gray-300 pl-11 pr-4 text-base text-gray-900 outline-none placeholder:text-gray-400 focus:border-green-900 focus:ring-1 focus:ring-green-900 sm:rounded-none sm:text-sm"
                :placeholder="placeholder"
                :displayValue="(option) => option?.name || option || ''"
                @input="query = $event.target.value"
                @keydown.backspace="
                    () => {
                        if (query === '') emit('update:modelValue', null);
                    }
                "
            />
            <component
                :is="icon"
                class="pointer-events-none col-start-1 row-start-1 ml-4 size-5 self-center text-gray-400"
                aria-hidden="true"
            />

            <ComboboxOptions
                v-if="filteredOptions.length > 0"
                static
                class="absolute top-full z-10 mt-1 max-h-72 w-full overflow-y-auto rounded-md border border-gray-300 bg-white py-2 text-sm text-gray-800"
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
                            <div
                                v-if="option.type"
                                class="text-xs text-gray-500"
                                :class="active && 'text-orange-50'"
                            >
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
