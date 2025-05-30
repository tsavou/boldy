<script setup>
import Layout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Layout>
        <div
            class="mx-auto my-4 max-w-5xl rounded-lg bg-orange-100 px-4 py-12 shadow-md sm:px-6 lg:px-8"
        >
            <h1 class="mb-6 text-3xl font-bold">Mentions légales</h1>

            <h2 class="mb-2 mt-6 text-xl font-semibold">Éditeur du site</h2>
            <p class="text-sm">
                Ce site est édité par : <br />
                <strong>Boldy</strong><br />
                10 rue des Freelances, 75000 Paris, France<br />
                Email : <strong>contact@boldy.io</strong>
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">
                Responsable de la publication
            </h2>
            <p class="text-sm">
                Nom : <strong>Nom du responsable</strong><br />
                Email : <strong>contact@boldy.io</strong>
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">Hébergement</h2>
            <p class="text-sm">
                Ce site est hébergé par : <br />
                <strong>Laravel Cloud</strong><br />
                <a
                    href="http://cloud.laravel.com"
                    target="_blank"
                    class="font-bold text-green-900 hover:underline"
                    >https://cloud.laravel.com</a
                >
                <br />
                Email:
                <a
                    href="mailto:cloud@laravel.com"
                    class="font-bold text-green-900 hover:underline"
                    >cloud@laravel.com</a
                >
            </p>

            <h2 class="mb-2 mt-6 text-xl font-semibold">
                Propriété intellectuelle
            </h2>
            <p class="text-sm">
                Tout le contenu présent sur Boldy est protégé par les lois en
                vigueur sur la propriété intellectuelle. Toute reproduction ou
                diffusion est interdite sans autorisation préalable.
            </p>
        </div>
    </Layout>
</template>
