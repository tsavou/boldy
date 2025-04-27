<script setup>
import Layout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    boosted: Array,
    categories: Array,
});
</script>

<template>
    <Head title="Accueil" />

    <Layout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Accueil
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!--                        Bandeau à propos + CTA rejoindre boldy (si non connecté)-->

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

                    <!--
                    si connecté speech + CTA qui mene vers les différents plans de tarifs (gratuit, premium, boost)
-->
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

            <div>
                <h3>Freelances en vedette</h3>
                <div v-for="freelance in boosted" :key="freelance.id">
                    <Link :href="route('freelance.show', freelance.slug)">
                        {{ freelance.user.first_name }} {{ freelance.user.name }}
                    </Link>
                    <img
                        :src="freelance.profile_picture"
                        alt="profile picture"
                    />
                </div>
            </div>
            <div>
                <h3>Freelances</h3>
                <div v-for="job in categories" :key="job.id">
                    <h4>{{ job.name }}</h4>
                </div>
            </div>
        </div>
    </Layout>
</template>
