<script setup>
  import Layout from '@/Layouts/AuthenticatedLayout.vue'
  import { Head } from '@inertiajs/vue3'

  defineProps({
      freelances: Object
  })
</script>

<template>
  <Layout>
    <Head title="Freelances Catalog" />

      <div v-for="freelance in freelances" :key="freelance.id">
          {{ freelance.user.first_name }}
          {{ freelance.user.name }}

          <a :href="route('freelance.show', freelance.id)">Voir le profil</a>
      </div>

  </Layout>
</template>
