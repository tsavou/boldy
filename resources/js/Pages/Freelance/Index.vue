<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { computed, reactive, ref, watch } from 'vue';
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import {
    XMarkIcon,
    MapPinIcon,
    AdjustmentsHorizontalIcon,
} from '@heroicons/vue/24/outline';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import SearchBar from '@/Components/SearchBar.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AdvancedFilters from '@/Components/FreelancesCatalog/AdvancedFilters.vue';
import PaginationNavigation from '@/Components/PaginationNavigation.vue';
import FreelanceCard from '@/Components/FreelancesCatalog/FreelanceCard.vue';

const props = defineProps({
    freelances: Object,
    professions: Array,
    skills: Array,
    cities: Array,
    activeFilters: Object,
});

const filters = reactive({
    selectedSearchOption:
        props.activeFilters.job || props.activeFilters.skill || null,
    search: props.activeFilters.search || '',
    city: props.activeFilters.city || null,
    priceRange: [
        props.activeFilters.min_price || 0,
        props.activeFilters.max_price || 1500,
    ],
    experienceRange: [
        props.activeFilters.min_exp || 0,
        props.activeFilters.max_exp || 10,
    ],
    level: props.activeFilters.level || [],
    available: props.activeFilters.available || null,
    sort: props.activeFilters.sort || null,
});

// création d'un tableau avec les métiers et les compétences en ajoutant un type pour les différencier
const searchOptions = computed(() => {
    return [
        ...props.professions.map((profession) => ({
            ...profession,
            type: 'Métier',
        })),
        ...props.skills.map((skill) => ({ ...skill, type: 'Compétence' })),
    ];
});

const sortOptions = [
    { label: 'Expérience (Croissant)', value: 'experience_asc' },
    { label: 'Expérience (Décroissant)', value: 'experience_desc' },
    { label: 'Récents', value: 'recent' },
    { label: 'Tarif (Croissant)', value: 'price_asc' },
    { label: 'Tarif (Décroissant)', value: 'price_desc' },
];

const mobileFiltersOpen = ref(false);

const applyFilters = () => {
    const params = {};

    if (filters.selectedSearchOption) {
        if (typeof filters.selectedSearchOption === 'object') {
            const { type, name } = filters.selectedSearchOption;
            if (type === 'Métier') params.job = name;
            if (type === 'Compétence') params.skill = name;
        } else {
            // selectedSearchOption est une chaîne de caractères lorsque le job est sélectionné depuis la page d'accueil
            params.job = filters.selectedSearchOption;
        }
    }

    if (filters.search) params.search = filters.search;
    if (filters.city) params.city = filters.city;

    if (filters.priceRange[0] > 0) params.min_price = filters.priceRange[0];
    if (filters.priceRange[1] < 1500) params.max_price = filters.priceRange[1];

    if (filters.experienceRange[0] > 0)
        params.min_exp = filters.experienceRange[0];
    if (filters.experienceRange[1] < 10)
        params.max_exp = filters.experienceRange[1];
    if (filters.level.length > 0) params.level = filters.level;
    if (filters.available) params.available = 1;
    if (filters.sort) params.sort = filters.sort;

    router.get(route('freelance.index'), params, {
        preserveScroll: true,
        preserveState: true,
    });
};
const sortBy = (option) => {
    filters.sort = option.value;
    applyFilters();
};

const sortLabel = computed(() => {
    return props.activeFilters.sort
        ? sortOptions.find(
              (option) => option.value === props.activeFilters.sort,
          )?.label
        : '';
});

const hasActiveFilters = computed(() => {
    return Object.keys(props.activeFilters).length > 0;
});

const clearAllFilters = () => {
    filters.search = '';
    filters.city = '';
    filters.priceRange = [0, 1500];
    filters.experienceRange = [0, 10];
    filters.level = [];
    filters.available = false;
    filters.selectedSearchOption = null;
    filters.sort = null;
    applyFilters();
};

// Détection des changements dans filters avec debounce (pour éviter trop de requêtes à chaque caractère)
watch(
    filters,
    () => {
        applyFilters();
    },
    { deep: true },
);
</script>

<template>
    <Head title="Freelances" />
    <Layout>
        <div class="bg-orange-50">
            <!-- Mobile filter dialog -->
            <TransitionRoot as="template" :show="mobileFiltersOpen">
                <Dialog
                    class="relative z-50 md:hidden"
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
                                class="relative ml-auto flex size-full max-w-xs flex-col overflow-y-auto bg-orange-50 py-4 pb-12 shadow-xl"
                            >
                                <div
                                    class="mb-8 flex items-center justify-between px-4"
                                >
                                    <h2
                                        class="text-lg font-medium text-gray-900"
                                    >
                                        Filtres avancés
                                    </h2>
                                    <button
                                        type="button"
                                        class="-mr-2 flex size-10 items-center justify-center rounded-md bg-green-900 p-2 text-orange-50"
                                        @click="mobileFiltersOpen = false"
                                    >
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon
                                            class="size-6"
                                            aria-hidden="true"
                                        />
                                    </button>
                                </div>
                                <div class="mx-auto">
                                    <!-- Filters -->
                                    <AdvancedFilters
                                        v-model:filters="filters"
                                        :show-clear-button="hasActiveFilters"
                                        @clearFilters="clearAllFilters"
                                    />
                                </div>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </Dialog>
            </TransitionRoot>

            <div>
                <div class="relative overflow-hidden bg-orange-100">
                    <!-- Decorative background image and gradient -->
                    <div aria-hidden="true" class="absolute inset-0">
                        <div class="absolute inset-0 overflow-hidden">
                            <img
                                src="https://tailwindcss.com/plus-assets/img/ecommerce-images/home-page-02-sale-full-width.jpg"
                                alt=""
                                class="size-full object-cover object-top"
                            />
                        </div>
                        <div class="absolute inset-0 bg-orange-100/50" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-orange-100 via-orange-100/50"
                        />
                    </div>

                    <section
                        aria-labelledby="sale-heading"
                        class="relative mx-auto flex max-w-7xl flex-col items-center px-4 pb-8 pt-36 text-center sm:px-6 lg:px-8"
                    >
                        <div class="mx-auto max-w-2xl lg:max-w-none">
                            <h1
                                id="sale-heading"
                                class="text-4xl font-bold tracking-tight text-gray-900 sm:text-5xl lg:text-6xl"
                            >
                                Trouvez le bon freelance pour votre projet
                            </h1>
                            <p class="mt-4 text-center text-xl text-gray-600">
                                Plus de 10 000 freelances vérifiés vous
                                attendent : affinez votre recherche et trouvez
                                le talent qu’il vous faut.
                            </p>
                        </div>
                    </section>
                </div>

                <div class="sticky top-[64px] z-30 bg-orange-100 shadow-md">
                    <!-- Filters -->
                    <section
                        aria-labelledby="filter-heading"
                        class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
                    >
                        <h2 id="filter-heading" class="sr-only">Filtres</h2>

                        <div
                            class="flex w-full flex-col gap-y-4 md:flex-row md:gap-y-0"
                        >
                            <!-- SearchBars-->
                            <div class="basis-2/3">
                                <SearchBar
                                    v-model="filters.selectedSearchOption"
                                    v-model:query="filters.search"
                                    :options="searchOptions"
                                    placeholder="Métier, compétence..."
                                />
                            </div>

                            <div class="basis-1/3">
                                <SearchBar
                                    v-model="filters.city"
                                    :options="cities"
                                    :icon="MapPinIcon"
                                    placeholder="Ville"
                                />
                            </div>

                            <!-- Mobile Filters Button -->
                            <PrimaryButton
                                @click="mobileFiltersOpen = true"
                                class="w-full md:hidden"
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
                                <div class="hidden w-full md:block">
                                    <AdvancedFilters
                                        v-model:filters="filters"
                                        :show-clear-button="hasActiveFilters"
                                        @clearFilters="clearAllFilters"
                                    />
                                </div>
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
                            class="flex items-center gap-2 text-2xl font-bold tracking-tight text-gray-900"
                        >
                            Freelances
                            <span
                                class="inline-flex items-center justify-center rounded-full bg-green-800 px-2.5 py-1 text-sm font-semibold text-orange-50"
                            >
                                {{ freelances.total }}
                            </span>
                        </h2>
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                >
                                    Trier par : {{ sortLabel }}
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
                                            v-for="(
                                                option, index
                                            ) in sortOptions"
                                            :key="index"
                                            v-slot="{ active }"
                                        >
                                            <button
                                                @click="sortBy(option)"
                                                :class="[
                                                    active ? 'bg-gray-100' : '',
                                                    'block w-full px-4 py-2 text-left text-sm',
                                                ]"
                                            >
                                                {{ option.label }}
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </div>

                    <div
                        v-if="freelances.total > 0"
                        class="grid grid-cols-1 items-stretch justify-items-center gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                    >
                        <FreelanceCard
                            v-for="freelance in freelances.data"
                            :key="freelance.id"
                            :freelance="freelance"
                        />
                    </div>
                    <div v-else class="text-center text-xl text-green-900">
                        Aucun freelance correspondant à votre recherche
                    </div>
                </section>
                <!-- Pagination -->
                <div
                    class="flex items-center justify-center border-t border-gray-200 bg-orange-100 px-4 py-3 sm:justify-between sm:px-6"
                >
                    <div
                        class="flex sm:flex-1 sm:items-center sm:justify-between"
                    >
                        <div class="hidden sm:block">
                            <p class="text-sm text-gray-700">
                                Affichage de
                                <span class="font-medium">{{
                                    freelances.from
                                }}</span>
                                à
                                <span class="font-medium">{{
                                    freelances.to
                                }}</span>
                                sur
                                <span class="font-medium">{{
                                    freelances.total
                                }}</span>
                                résultats
                            </p>
                        </div>
                        <div>
                            <PaginationNavigation :links="freelances.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
