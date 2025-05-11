<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { onMounted, ref } from 'vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid';

const props = defineProps({
    boosted: Array,
    categories: Array,
    freelancesCount: Number,
});

const slider = ref(null);
const canScrollLeft = ref(false);
const canScrollRight = ref(false);

const stats = [
    { id: 1, name: 'Freelances inscrits', value: props.freelancesCount },
    { id: 2, name: 'Taux de satisfaction', value: '98%' },
    { id: 3, name: 'Catégories de métier', value: props.categories.length },
    { id: 4, name: 'Visiteurs par mois', value: '4 500+' },
];

const checkScroll = () => {
    canScrollLeft.value = slider.value.scrollLeft > 0;
    canScrollRight.value =
        slider.value.scrollLeft <
        slider.value.scrollWidth - slider.value.clientWidth;
};

const scrollLeft = () => {
    slider.value.scrollBy({
        left: -300,
        behavior: 'smooth',
    });
    checkScroll();
};

const scrollRight = () => {
    slider.value.scrollBy({
        left: 300,
        behavior: 'smooth',
    });
    checkScroll();
};

const getExperienceLevelColor = (level) => {
    switch (level) {
        case 'Junior':
            return 'bg-green-200 text-green-900 fill-green-500';
        case 'Intermédiaire':
            return 'bg-blue-300 text-blue-900 fill-blue-500';
        case 'Confirmé':
            return 'bg-indigo-200 text-indigo-900 fill-indigo-500';
        case 'Expert':
            return 'bg-purple-200 text-purple-900 fill-purple-500';
        default:
            return 'bg-gray-100 text-gray-900 fill-gray-400';
    }
};

const getTJMColor = (price) => {
    if (price < 250) return 'bg-green-200 text-green-900 fill-green-500';
    if (price < 500) return 'bg-yellow-200 text-yellow-900 fill-yellow-500';
    return 'bg-red-200 text-red-900 fill-red-500';
};

onMounted(() => {
    slider.value.addEventListener('scroll', checkScroll);
    window.addEventListener('resize', checkScroll);
    checkScroll();
});
</script>

<template>
    <Head title="Accueil" />

    <Layout>
        <section
            id="hero"
            class="relative isolate overflow-hidden text-orange-50"
        >
            <img
                src="/img/hero_bg.png"
                alt=""
                class="absolute inset-0 -z-10 size-full object-cover"
            />
            <div class="absolute inset-0 -z-10 bg-black/20"></div>
            <div
                class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                aria-hidden="true"
            >
                <div
                    class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#bef264] to-[#14532d] opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="
                        clip-path: polygon(
                            74.1% 44.1%,
                            100% 61.6%,
                            97.5% 26.9%,
                            85.5% 0.1%,
                            80.7% 2%,
                            72.5% 32.5%,
                            60.2% 62.4%,
                            52.4% 68.1%,
                            47.5% 58.3%,
                            45.2% 34.5%,
                            27.5% 76.7%,
                            0.1% 64.9%,
                            17.9% 100%,
                            27.6% 76.8%,
                            76.1% 97.7%,
                            74.1% 44.1%
                        );
                    "
                />
            </div>
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="max-w-4xl py-8 sm:py-40 2xl:py-64">
                    <!-- mx-auto ou pas ? -->
                    <div
                        class="mb-8 flex flex-wrap items-center justify-center gap-4 space-x-4 space-y-0 md:flex-row md:justify-start"
                    >
                        <div
                            class="relative rounded-full px-3 py-1 text-center text-sm/6 ring-1 ring-white/10 hover:ring-white/20"
                        >
                            Deviens visible comme une marque
                        </div>
                        <div
                            class="relative mt-2 rounded-full px-3 py-1 text-center text-sm/6 ring-1 ring-white/10 hover:ring-white/20"
                        >
                            Trouve ou deviens le bon profil
                        </div>
                        <div
                            class="relative mt-2 rounded-full px-3 py-1 text-center text-sm/6 ring-1 ring-white/10 hover:ring-white/20"
                        >
                            Attire les bons clients
                        </div>
                    </div>
                    <div class="sm:text-md/8 text-pretty">
                        <h1
                            class="text-balance text-center text-[2.5rem] font-semibold tracking-tight sm:text-left sm:text-7xl"
                        >
                            Révèle ton potentiel freelance avec Boldy
                        </h1>
                        <div
                            class="mt-8 flex flex-col items-center gap-2 md:flex-row md:flex-wrap"
                        >
                            <div
                                class="relative mr-2 rounded-full px-3 py-1 text-center font-bold ring-1 ring-white/10 hover:ring-white/20"
                            >
                                Freelance ?
                            </div>
                            <p class="text-center">
                                Crée un profil ultra-personnalisé, rejoins une
                                communauté engagée et booste ta visibilité
                                digitale.
                            </p>
                        </div>
                        <div
                            class="mt-8 flex flex-col items-center gap-2 md:flex-row md:flex-wrap"
                        >
                            <div
                                class="relative mr-2 rounded-full px-3 py-1 text-center font-bold ring-1 ring-white/10 hover:ring-white/20"
                            >
                                Besoin d’un freelance ?
                            </div>
                            <p class="text-center">
                                Trouve le profil idéal grâce à un catalogue
                                vivant et des filtres sur-mesure.
                            </p>
                        </div>

                        <p
                            class="mt-8 text-center text-orange-50/80 md:text-left"
                        >
                            Plus qu’un simple profil ou un annuaire : une vraie
                            communauté qui facilite la rencontre.
                        </p>

                        <div
                            class="mt-10 flex items-center justify-center gap-x-6 md:justify-start"
                        >
                            <PrimaryButton
                                as="Link"
                                size="xl"
                                :href="route('register')"
                                >Rejoindre Boldy
                                <span aria-hidden="true">→</span></PrimaryButton
                            >
                            <PrimaryButton
                                as="Link"
                                size="xl"
                                :href="route('freelance.index')"
                                color="secondary"
                                >Trouver un freelance
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
                aria-hidden="true"
            >
                <div
                    class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-[#bef264] to-[#14532d] opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                    style="
                        clip-path: polygon(
                            74.1% 44.1%,
                            100% 61.6%,
                            97.5% 26.9%,
                            85.5% 0.1%,
                            80.7% 2%,
                            72.5% 32.5%,
                            60.2% 62.4%,
                            52.4% 68.1%,
                            47.5% 58.3%,
                            45.2% 34.5%,
                            27.5% 76.7%,
                            0.1% 64.9%,
                            17.9% 100%,
                            27.6% 76.8%,
                            76.1% 97.7%,
                            74.1% 44.1%
                        );
                    "
                />
            </div>
        </section>

        <section class="relative bg-green-900 py-12">
            <div
                class="mx-auto mb-6 max-w-7xl px-4 sm:flex sm:items-center sm:justify-between sm:px-6 lg:px-8"
            >
                <h2
                    id="category-heading"
                    class="text-2xl font-bold tracking-tight text-orange-50"
                >
                    Freelances à la une
                </h2>
                <Link
                    :href="route('freelance.index')"
                    class="hidden text-sm font-semibold text-orange-50 hover:text-lime-300 sm:block"
                >
                    Voir tous les freelances
                    <span aria-hidden="true"> &rarr;</span>
                </Link>
            </div>
            <div class="group/slider relative px-6">
                <button
                    v-show="canScrollLeft"
                    @click="scrollLeft"
                    aria-label="Défiler vers la gauche"
                    class="group absolute bottom-0 left-0 top-0 z-20 flex w-12 items-center justify-center bg-gradient-to-r from-black/70 to-transparent opacity-0 transition hover:from-black/90 group-hover/slider:opacity-100"
                >
                    <ChevronLeftIcon
                        class="h-10 w-10 text-orange-50 transition-transform duration-200 ease-in-out group-hover:scale-125"
                    />
                </button>
                <div
                    ref="slider"
                    class="scrollbar-hide -mx-6 flex space-x-4 overflow-x-auto px-6 pb-4"
                >
                    <Link
                        v-for="freelance in boosted"
                        :key="freelance.id"
                        :href="route('freelance.show', freelance.slug)"
                        class="group relative h-80 w-48 flex-shrink-0 overflow-hidden rounded-2xl shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl"
                    >
                        <img
                            :src="
                                freelance.profile_picture ||
                                '/img/default_avatar.jpg'
                            "
                            :alt="`Photo de ${freelance.user.first_name} ${freelance.user.name}`"
                            class="h-full w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"
                        ></div>

                        <!-- Badge expérience -->
                        <span
                            class="absolute left-2 top-2 inline-flex items-center gap-x-1.5 rounded-full px-2 py-0.5 text-xs font-medium"
                            :class="
                                getExperienceLevelColor(
                                    freelance.experience_level,
                                )
                            "
                        >
                            {{ freelance.experience_level }}
                            ({{ freelance.experience_in_years }} ans)
                        </span>

                        <!-- Badge TJM -->
                        <span
                            class="absolute left-2 top-8 inline-flex items-center gap-x-1.5 rounded-full px-2 py-0.5 text-xs font-medium"
                            :class="getTJMColor(freelance.price_per_day)"
                        >
                            {{ freelance.price_per_day }} € / j
                        </span>

                        <div
                            class="absolute inset-x-0 bottom-0 h-1/4 rounded-b-xl rounded-t-sm bg-green-900/60 p-3 text-white backdrop-blur-sm"
                        >
                            <h3 class="text-md font-semibold leading-tight">
                                {{ freelance.user.first_name }}
                                {{ freelance.user.name }}
                            </h3>
                            <p class="mt-2 text-xs leading-snug">
                                {{
                                    freelance.professions
                                        .map((p) => p.name)
                                        .join(', ')
                                }}
                            </p>
                        </div>
                    </Link>
                </div>
                <button
                    v-show="canScrollRight"
                    @click="scrollRight"
                    aria-label="Défiler vers la droite"
                    class="group absolute bottom-0 right-0 top-0 z-20 flex w-12 items-center justify-center bg-gradient-to-r from-black/70 to-transparent opacity-0 transition hover:from-black/90 group-hover/slider:opacity-100"
                >
                    <ChevronRightIcon
                        class="h-10 w-10 text-orange-50 transition-transform duration-200 ease-in-out group-hover:scale-125"
                    />
                </button>
            </div>
        </section>

        <section class="relative">
            <div class="mx-auto max-w-7xl">
                <div class="relative z-10 lg:w-full lg:max-w-2xl">
                    <svg
                        class="absolute inset-y-0 right-8 hidden h-full w-80 translate-x-1/2 transform fill-orange-50 lg:block"
                        viewBox="0 0 100 100"
                        preserveAspectRatio="none"
                        aria-hidden="true"
                    >
                        <polygon points="0,0 90,0 50,100 0,100" />
                    </svg>

                    <div class="relative px-6 py-12 lg:px-8 lg:pr-0">
                        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl">
                            <h2
                                class="text-pretty text-4xl font-bold tracking-tight text-green-900"
                            >
                                Les métiers de nos Bolders
                            </h2>
                            <p class="mt-2 text-green-900">
                                Explore les spécialités de nos freelances et
                                trouve ton expert en quelques clics.
                            </p>

                            <ul
                                class="mt-5 grid grid-cols-1 gap-4 sm:grid-cols-2"
                            >
                                <li
                                    v-for="category in categories"
                                    :key="category.id"
                                >
                                    <Link
                                        :href="
                                            route('freelance.index', {
                                                category: category.id,
                                            })
                                        "
                                        class="block rounded-lg bg-green-800 py-2 text-center font-medium text-orange-50 transition hover:bg-green-700"
                                    >
                                        {{ category.name }} ({{
                                            category.freelances_count
                                        }})
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="bg-green-800 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2"
            >
                <div class="relative lg:h-full">
                    <div class="absolute inset-0 bg-green-900/40"></div>
                    <!-- Filtre semi-transparent vert -->
                    <img
                        class="aspect-[3/2] object-cover lg:aspect-auto lg:size-full"
                        src="https://images.unsplash.com/photo-1483389127117-b6a2102724ae?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1587&q=80"
                        alt="Illustration métiers"
                    />
                </div>
            </div>
        </section>

        <section class="bg-green-900 py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:max-w-none">
                    <div class="text-center">
                        <h2
                            class="text-balance text-4xl font-semibold tracking-tight text-orange-50 sm:text-5xl"
                        >
                            La communauté Boldy en chiffres
                        </h2>
                        <p class="mt-4 text-lg/8 text-orange-50/80">
                            Des freelances visibles et des clients satisfaits.
                        </p>
                    </div>
                    <dl
                        class="mt-16 grid grid-cols-1 gap-2 overflow-hidden rounded-2xl text-center sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <div
                            v-for="stat in stats"
                            :key="stat.id"
                            class="flex flex-col rounded-xl bg-green-800/50 p-8"
                        >
                            <dt
                                class="text-sm/6 font-semibold text-orange-50/80"
                            >
                                {{ stat.name }}
                            </dt>
                            <dd
                                class="order-first text-3xl font-semibold tracking-tight text-orange-50"
                            >
                                {{ stat.value }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </section>
    </Layout>
</template>
