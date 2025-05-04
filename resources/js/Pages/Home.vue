<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    boosted: Array,
    categories: Array,
});

const getExperienceLevelColor = (level) => {
    switch (level) {
        case 'Junior':
            return 'bg-gray-500';
        case 'Intermédiaire':
            return 'bg-orange-500';
        case 'Confirmé':
            return 'bg-emerald-600';
        case 'Expert':
            return 'bg-purple-700';
        default:
            return 'bg-gray-500';
    }
};

const getTJMColor = (price) => {
    if (price < 250) return 'bg-lime-400';
    if (price < 500) return 'bg-yellow-400';
    return 'bg-red-400';
};
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
                                >Trouver un freelance</PrimaryButton
                            >
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

<!--        TODO: améliorer le design de la section des freelances à la une: les badges color, la taille du bas de la card, badge premium, localisation, etc.-->
        <section class="bg-green-900 py-12">
            <div class="mx-auto max-w-7xl px-6">
                <h2 class="mb-6 text-2xl font-bold text-center text-orange-50">
                    Freelances à la une
                </h2>
                <div
                    class="scrollbar-hide -mx-6 flex items-center space-x-4 overflow-x-auto px-6 pb-4 md:justify-center"
                >
                    <Link
                        v-for="freelance in boosted"
                        :key="freelance.id"
                        :href="route('freelance.show', freelance.slug)"
                        class="group relative h-[50vh] w-[50vw] flex-shrink-0 overflow-hidden rounded-xl shadow-lg md:w-[20vw]"
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
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"
                        ></div>
                        <!-- Badge expérience -->
                        <span
                            class="absolute left-2 top-2 rounded-full px-2 py-0.5 text-xs font-medium text-white"
                            :class="
                                getExperienceLevelColor(
                                    freelance.experience_level,
                                )
                            "
                        >
                            ⭐️
                            {{ freelance.experience_level }}
                            ({{ freelance.experience_in_years }} ans)
                        </span>

                        <span
                            :class="`absolute left-2 top-8 rounded-full px-2 py-0.5 text-xs font-medium text-green-900 shadow-sm ${getTJMColor(freelance.price_per_day)}`"
                        >
                            💶
                            {{ freelance.price_per_day }} € / jour
                        </span>

                        <div
                            class="absolute inset-x-0 bottom-0 rounded-b-xl bg-black/40 p-3 text-white backdrop-blur-sm"
                        >
                            <h3 class="text-sm font-semibold leading-tight">
                                {{ freelance.user.first_name }}
                                {{ freelance.user.name }}
                            </h3>
                            <p class="mt-1 text-xs leading-snug">
                                {{
                                    freelance.professions
                                        .map((p) => p.name)
                                        .join(', ')
                                }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <div class="py-12">
            <!--
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        &lt;!&ndash;                        Bandeau à propos + CTA rejoindre boldy (si non connecté)&ndash;&gt;

                        <p>Bienvenue sur Boldy !</p>
                        <p>
                            Boldy est une plateforme qui référence les
                            freelances du digital.
                        </p>
                        <p>
                            A la recherche d'un développeur, d'un designer, d'un
                            community manager...... ? Vous êtes au bon endroit.
                        </p>
                        <p>
                            Si vous êtes freelance, vous pouvez créer un profil
                            et être référencé sur Boldy.
                        </p>
                       <div class="flex gap-4">
                           <PrimaryButton as="Link" :href="route('register')" >Rejoindre Boldy</PrimaryButton>
                       </div>

                    </div>

                    &lt;!&ndash;
                    si connecté speech + CTA qui mene vers les différents plans de tarifs (gratuit, premium, boost)
&ndash;&gt;
                    <div class="p-6 text-gray-900">
                        <p>Vous êtes connecté !</p>
                        <p>
                            Vous pouvez maintenant créer un profil et être
                            référencé sur Boldy.
                        </p>
                        <p>
                            Vous pouvez aussi consulter les profils des autres
                            freelances.
                        </p>
                        <p>
                            Besoin d'un boost pour être visible en haut des
                            résultats ?
                        </p>
                        <p>
                            Besoin d'un plan premium pour accéder à des
                            fonctionnalités supplémentaires ? (plan
                            d'accompagnement, plan de visibilité, plan de
                            communication, possibilité de mettre plus de photos,
                            interviews vidéos de notre équipe, etc... )
                        </p>
                        <Link :href="route('home')" class="btn-primary"> vers les tarifs ?</Link>
                        <div />
                    </div>
                </div>
            </div>
-->
        </div>
    </Layout>
</template>
