<script setup>
import { computed, ref, watch } from 'vue';
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue';
import {
    CheckIcon,
    ChevronUpDownIcon,
    XMarkIcon,
} from '@heroicons/vue/20/solid';

const props = defineProps({
    modelValue: Array,
    options: {
        type: [Array, Function],
        default: () => [],
    },
    placeholder: {
        type: String,
        default: 'Sélectionnez une ou plusieurs options...',
    },
    valueKey: {
        type: String,
        default: 'id',
    },
    labelKey: {
        type: String,
        default: 'label',
    },
});

const emit = defineEmits(['update:modelValue']);

const searchQuery = ref('');
const internalOptions = ref([]);

const checkedItems = computed({
    get() {
        return props.modelValue || [];
    },
    set(value) {
        emit('update:modelValue', value);
    },
});

watch(
    searchQuery,
    async (newValue) => {
        internalOptions.value = newValue
            ? props.options.filter((item) =>
                  item[props.labelKey]
                      .toLowerCase()
                      .includes(String(newValue).toLowerCase()),
              )
            : props.options;
    },
    { immediate: true },
);

watch(checkedItems, (newValue) => {
    emit('update:modelValue', newValue);
});

const removeItem = (id) => {
    checkedItems.value = checkedItems.value.filter((item) => item !== id);
};

const getLabel = (id) => {
    return props.options.find((option) => option[props.valueKey] === id)?.[
        props.labelKey
    ];
};
</script>

<template>
    <Combobox v-model="checkedItems" multiple as="div">
        <div class="relative">
            <!-- Tags sélectionnés -->
            <div class="mb-2 flex flex-wrap gap-2">
                <span
                    v-for="id in checkedItems"
                    :key="id"
                    class="flex items-center gap-1 rounded-full bg-green-800 px-3 py-1 text-sm text-orange-50 shadow"
                >
                    {{ getLabel(id) }}
                    <button
                        type="button"
                        @click="removeItem(id)"
                        class="hover:text-lime-300"
                    >
                        <XMarkIcon class="h-4 w-4" />
                    </button>
                </span>
            </div>

            <ComboboxButton as="div" class="relative">
                <ComboboxInput
                    @change="searchQuery = $event.target.value"
                    @blur="searchQuery = ''"
                    class="w-full rounded-lg border border-orange-100 bg-white py-2 pl-3 pr-10 text-sm text-green-900 focus:border-green-900 focus:ring-1 focus:ring-green-900"
                    :placeholder="checkedItems.length === 0 ? placeholder : ''"
                />
                <div
                    class="absolute inset-y-0 right-0 flex cursor-pointer items-center pr-3"
                >
                    <ChevronUpDownIcon class="h-5 w-5 text-green-900" />
                </div>
            </ComboboxButton>

            <ComboboxOptions
                v-if="internalOptions.length > 0"
                class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 sm:text-sm"
            >
                <ComboboxOption
                    v-for="option in internalOptions"
                    :key="option[valueKey]"
                    :value="option[valueKey]"
                    as="template"
                    v-slot="{ active, selected }"
                >
                    <li
                        :class="[
                            'relative cursor-default select-none py-2 pl-3 pr-9',
                            active
                                ? 'bg-green-900 text-orange-50'
                                : 'text-green-900',
                        ]"
                    >
                        <span
                            :class="[
                                'block truncate',
                                selected ? 'font-semibold' : '',
                            ]"
                        >
                            {{ option[labelKey] }}
                        </span>

                        <span
                            v-if="selected"
                            class="absolute inset-y-0 right-0 flex items-center pr-4"
                        >
                            <CheckIcon
                                :class="[
                                    'h-5 w-5',
                                    active
                                        ? 'text-orange-50'
                                        : 'text-green-900',
                                ]"
                            />
                        </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>
