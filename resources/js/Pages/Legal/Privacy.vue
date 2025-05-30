<script setup>
import Layout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Layout>
        <div
            class="mx-auto my-4 max-w-5xl rounded-lg bg-orange-100 px-4 py-12 shadow-md sm:px-6 lg:px-8"
        >
            <h1 class="mb-6 text-3xl font-bold">
                Politique de Confidentialité
            </h1>

            <p class="mb-4 text-sm">
                Boldy attache une grande importance à la protection des données
                personnelles de ses utilisateurs.
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">
                1. Données collectées
            </h2>
            <p class="text-sm">
                Nous collectons les données fournies lors de l’inscription (nom,
                email, profession, photo, expériences, services proposés).
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">
                2. Utilisation des données
            </h2>
            <p class="text-sm">
                Les données sont utilisées pour afficher les profils, gérer les
                options payantes et améliorer le service. Elles ne sont jamais
                cédées à des tiers.
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">3. Vos droits</h2>
            <p class="text-sm">
                Conformément à la réglementation RGPD, vous disposez d’un droit
                d’accès, de rectification et de suppression de vos données via
                votre compte ou en nous contactant à
                <strong>contact@boldy.io</strong>.
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">4. Cookies</h2>
            <p class="text-sm">
                Boldy utilise des cookies à des fins de mesure d’audience et de
                navigation. Vous pouvez gérer vos préférences dans les
                paramètres de votre navigateur.
            </p>
        </div>
    </Layout>
</template>
