<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
    Switch,
    SwitchGroup,
    SwitchLabel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import {
    XMarkIcon,
    MapPinIcon,
    AdjustmentsHorizontalIcon,
    ArrowPathIcon,
} from '@heroicons/vue/24/outline';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import SearchBar from '@/Components/SearchBar.vue';
import Slider from '@vueform/slider';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    freelances: Object,
    professions: Array,
    skills: Array,
    cities: Array,
    filters: Object,
});

const searchOptions = computed(() => {
    return [
        ...props.professions.map((profession) => ({
            ...profession,
            type: 'Métier',
        })),
        ...props.skills.map((skill) => ({ ...skill, type: 'Compétence' })),
    ];
});

const selectedSearchOption = ref(null);
const curentSearchQuery = ref('');
const selectedCity = ref(null);

const selectedLevels = ref([]);

const availability = ref(false);

const priceRange = ref([0, 1500]);
const experienceRange = ref([0, 50]);

const levels = [
    { id: 1, name: 'Junior' },
    { id: 2, name: 'Intermédiaire' },
    { id: 3, name: 'Confirmé' },
    { id: 4, name: 'Expert' },
];
const sortOptions = [
    { label: 'Expérience: (Croissant)', value:'experience_asc' },
    { label: 'Expérience: (Décroissant)', value:'experience_desc' },
    { label: 'Récents', value:'recent' },
    { label: 'Tarif (Croissant)', value:'price_asc'},
    { label: 'Tarif (Décroissant)', value:'price_desc' },
];
const activeFilters = [{ value: 'objects', label: 'Objects' }];

const mobileFiltersOpen = ref(false);

const sortBy = (option) => {
    router.get(
        route('freelance.index'),
        {
            sort: option,
        },
        {
            preserveScroll: true,
        }
    );
}
</script>

<template>
    <Head title="Freelances" />
    <Layout>
        <div class="">
            <!-- Mobile filter dialog -->
            <TransitionRoot as="template" :show="mobileFiltersOpen">
                <Dialog
                    class="relative z-40 sm:hidden"
                    @close="mobileFiltersOpen = false"
                >
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
                                class="relative ml-auto flex size-full max-w-xs flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl"
                            >
                                <div
                                    class="flex items-center justify-between px-4"
                                >
                                    <h2
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        Filters
                                    </h2>
                                    <button
                                        type="button"
                                        class="-mr-2 flex size-10 items-center justify-center rounded-md bg-white p-2 text-gray-400"
                                        @click="mobileFiltersOpen = false"
                                    >
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon
                                            class="size-6"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>

                                <!-- Filters -->
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>

            <div>
                <h1
                    class="bg-orange-100 px-4 py-8 text-center text-3xl font-bold tracking-tight text-green-900 sm:px-6 lg:px-8"
                >
                    Trouvez le bon freelance
                </h1>
                <div class="bg-orange-100 sticky top-[64px] z-50">
                    <!-- Filters -->
                    <section
                        aria-labelledby="filter-heading"
                        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                    >
                        <h2 id="filter-heading" class="sr-only">Filtres</h2>

                        <div
                            class="flex w-full flex-col gap-y-4 sm:flex-row sm:gap-y-0"
                        >
                            <!-- SearchBars-->
                            <div class="basis-2/3">
                                <SearchBar
                                    v-model="selectedSearchOption"
                                    v-model:query="curentSearchQuery"
                                    :options="searchOptions"
                                    placeholder="Métier, compétence..."
                                />
                            </div>

                            <div class="basis-1/3">
                                <SearchBar
                                    v-model="selectedCity"
                                    :options="cities"
                                    :icon="MapPinIcon"
                                    placeholder="Ville"
                                />
                            </div>

                            <!-- Mobile Filters Button -->
                            <PrimaryButton
                                @click="mobileFiltersOpen = true"
                                class="w-full sm:hidden"
                            >
                                <AdjustmentsHorizontalIcon
                                    class="size-5"
                                    aria-hidden="true"
                                />
                                <span>Filtres</span>
                            </PrimaryButton>
                        </div>

                        <!-- Filters Section -->
                        <div class="border-b border-gray-200 pb-4 pt-4">
                            <div class="flex items-center justify-between">
                                <!-- Desktop Filters -->
                                <div class="hidden w-full sm:block">
                                    <div
                                        class="flex flex-wrap items-center gap-12"
                                    >
                                        <h3
                                            class="mb-4 text-sm font-medium text-gray-500"
                                        >
                                            Filtres avancés :
                                        </h3>

                                        <!-- Price Range -->

                                        <div
                                            class="flex w-48 flex-col space-y-2"
                                        >
                                            <label
                                                class="block text-sm font-medium text-gray-700"
                                                >Tarif indicatif (/jour)</label
                                            >

                                            <Slider
                                                v-model="priceRange"
                                                :min="0"
                                                :max="1500"
                                                :step="10"
                                                showTooltip="drag"
                                                tooltipPosition="top"
                                                :merge="500"
                                                :format="
                                                    (v) => `${Math.round(v)}€`
                                                "
                                            />
                                            <div
                                                class="flex justify-between text-sm text-gray-500"
                                            >
                                                <span
                                                    >{{ priceRange[0] }}€</span
                                                >
                                                <span
                                                    >{{ priceRange[1] }}€</span
                                                >
                                            </div>
                                        </div>

                                        <!-- Experience Level -->
                                        <div
                                            class="flex w-48 flex-col space-y-2"
                                        >
                                            <label
                                                class="block text-sm font-medium text-gray-700"
                                                >Années d'expérience</label
                                            >

                                            <Slider
                                                v-model="experienceRange"
                                                :min="0"
                                                :max="60"
                                                :step="1"
                                                :merge="10"
                                                showTooltip="drag"
                                            />

                                            <div
                                                class="flex justify-between text-sm text-gray-500"
                                            >
                                                <span>{{
                                                    experienceRange[0]
                                                }}</span>
                                                <span>{{
                                                    experienceRange[1]
                                                }}</span>
                                            </div>
                                        </div>

                                        <PopoverGroup
                                            class="hidden sm:flex sm:items-baseline sm:space-x-8"
                                        >
                                            <Popover
                                                as="div"
                                                class="relative inline-block text-left"
                                            >
                                                <div>
                                                    <PopoverButton
                                                        class="group inline-flex items-center justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                                    >
                                                        <span
                                                            >Niveau
                                                            d'expérience</span
                                                        >
                                                        <span
                                                            v-if="
                                                                selectedLevels.length >
                                                                0
                                                            "
                                                            class="ml-1.5 rounded bg-green-900 px-1.5 py-0.5 text-xs font-semibold text-white"
                                                        >
                                                            {{
                                                                selectedLevels.length
                                                            }}
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
                                                        class="absolute right-0 z-10 mt-2 origin-top-right rounded-md bg-white p-4 shadow-2xl ring-1 ring-black/5 focus:outline-none"
                                                    >
                                                        <form class="space-y-4">
                                                            <div
                                                                v-for="(
                                                                    level,
                                                                    levelIdx
                                                                ) in levels"
                                                                :key="level.id"
                                                                class="flex gap-3"
                                                            >
                                                                <div
                                                                    class="flex h-5 shrink-0 items-center"
                                                                >
                                                                    <div
                                                                        class="group grid size-4 grid-cols-1"
                                                                    >
                                                                        <input
                                                                            :id="`level-${level.id}`"
                                                                            name="experience[]"
                                                                            :value="
                                                                                level.id
                                                                            "
                                                                            type="checkbox"
                                                                            v-model="
                                                                                selectedLevels
                                                                            "
                                                                            class="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-green-900 checked:bg-green-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-900"
                                                                        />
                                                                        <svg
                                                                            class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white"
                                                                            viewBox="0 0 14 14"
                                                                            fill="none"
                                                                        >
                                                                            <path
                                                                                class="opacity-0 group-has-[:checked]:opacity-100"
                                                                                d="M3 8L6 11L11 3.5"
                                                                                stroke-width="2"
                                                                                stroke-linecap="round"
                                                                                stroke-linejoin="round"
                                                                            />
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <label
                                                                    :for="`level-${level.id}`"
                                                                    class="whitespace-nowrap pr-6 text-sm font-medium text-gray-900"
                                                                    >{{
                                                                        level.name
                                                                    }}</label
                                                                >
                                                            </div>
                                                        </form>
                                                    </PopoverPanel>
                                                </transition>
                                            </Popover>
                                        </PopoverGroup>

                                        <!-- Availability -->
                                        <SwitchGroup
                                            as="div"
                                            class="flex items-center"
                                        >
                                            <Switch
                                                v-model="availability"
                                                :class="[
                                                    availability
                                                        ? 'bg-green-900'
                                                        : 'bg-gray-200',
                                                    'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out',
                                                ]"
                                            >
                                                <span
                                                    aria-hidden="true"
                                                    :class="[
                                                        availability
                                                            ? 'translate-x-5'
                                                            : 'translate-x-0',
                                                        'pointer-events-none inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out',
                                                    ]"
                                                />
                                            </Switch>
                                            <SwitchLabel
                                                as="span"
                                                class="ml-3 text-sm"
                                            >
                                                <span
                                                    class="font-medium text-gray-900"
                                                    >Disponible</span
                                                >
                                                {{ ' ' }}
                                            </SwitchLabel>
                                        </SwitchGroup>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Filters -->
                        <div class="mt-4 pb-4">
                            <div class="flex flex-wrap items-center gap-3">
                                <div
                                    v-for="activeFilter in activeFilters"
                                    :key="activeFilter.value"
                                >
                                    <span
                                        class="inline-flex items-center rounded-full border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-800"
                                    >
                                        {{ activeFilter.label }}
                                        <button
                                            type="button"
                                            class="ml-2 flex size-4 items-center justify-center rounded-full text-gray-400 hover:bg-gray-200 hover:text-gray-600"
                                            @click="removeFilter(activeFilter)"
                                        >
                                            <span class="sr-only"
                                                >Supprimer
                                                {{ activeFilter.label }}</span
                                            >
                                            <svg
                                                class="size-2"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 8 8"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-width="1.5"
                                                    d="M1 1l6 6m0-6L1 7"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </div>

                                <button
                                    v-if="activeFilters.length > 0"
                                    type="button"
                                    class="text-sm text-gray-500 hover:underline"
                                    @click="clearAllFilters"
                                >
                                    <ArrowPathIcon
                                        class="inline size-4"
                                        aria-hidden="true"
                                    />
                                    Tout effacer
                                </button>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Freelances grid -->
                <section
                    aria-labelledby="freelances-heading"
                    class="mx-auto max-w-2xl bg-orange-50 px-4 pb-16 sm:px-6 sm:pb-24 lg:max-w-7xl lg:px-8"
                >
                    <div class="flex items-center justify-between py-8">
                        <h2
                            id="freelances-heading"
                            class="text-2xl font-bold tracking-tight text-gray-900"
                        >
                            Freelances ({{ freelances.total }})
                        </h2>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                >
                                    Trier par
                                    <ChevronDownIcon
                                        class="-mr-1 ml-1 size-5 shrink-0 text-gray-400 group-hover:text-gray-500"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <MenuItems
                                    class="absolute right-0 z-10 mt-2 w-60 origin-top-left rounded-md bg-white shadow-2xl ring-1 ring-black/5 focus:outline-none"
                                >
                                    <div class="py-1">
                                        <MenuItem
                                            v-for="(option, index) in sortOptions"
                                            :key="index"
                                            v-slot="{ active }"
                                        >
                                            <button
                                                @click="sortBy(option.value)"
                                                :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm w-full text-left']"
                                            >
                                                {{option.label}}
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>

                    <div
                        class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8"
                    >
                        <Link
                            v-for="freelance in freelances.data"
                            :key="freelance.id"
                            :href="route('freelance.show', freelance.slug)"
                            class="group"
                        >
                            <img
                                :src="
                                    freelance.profile_picture ||
                                    '/img/default_avatar.jpg'
                                "
                                :alt="`Photo de profil de  ${freelance.full_name}`"
                                class="aspect-square w-full rounded-lg bg-gray-200 object-cover group-hover:opacity-75 xl:aspect-[7/8]"
                            />
                            <h3 class="mt-4 text-sm text-gray-700">
                                {{ freelance.first_name }}
                            </h3>
                            <p class="mt-1 text-lg font-medium text-gray-900">
                                {{ freelance.price_per_day }} €/jour
                            </p>
                        </Link>
                    </div>
                </section>
            </div>
        </div>
    </Layout>
</template>
<style src="@vueform/slider/themes/default.css"></style>
