<script setup>
import Layout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <Layout>
        <div class="mx-auto max-w-3xl py-12">
            <h1 class="text-3xl font-bold mb-6">Mentions légales</h1>

            <h2 class="text-xl font-semibold mt-6 mb-2">Éditeur du site</h2>
            <p class="text-sm">
                Ce site est édité par : <br />
                <strong>Boldy</strong><br />
                10 rue des Freelances, 75000 Paris, France<br />
                Email : <strong>contact@boldy.io</strong>
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Responsable de la publication</h2>
            <p class="text-sm">
                Nom : <strong>Nom du responsable</strong><br />
                Email : <strong>contact@boldy.io</strong>
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Hébergement</h2>
            <p class="text-sm">
                Ce site est hébergé par : <br />
                <strong>Laravel Cloud</strong><br />
                https://cloud.laravel.com<br />
                Email: cloud@laravel.com
            </p>

            <h2 class="text-xl font-semibold mt-6 mb-2">Propriété intellectuelle</h2>
            <p class="text-sm">
                Tout le contenu présent sur Boldy est protégé par les lois en vigueur sur la propriété intellectuelle.
                Toute reproduction ou diffusion est interdite sans autorisation préalable.
            </p>
        </div>
    </Layout>
</template>
