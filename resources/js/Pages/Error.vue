<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    status: String,
    message: String,
});
</script>

<template>
    <AppLayout>
        <div
            class="grid min-h-[100svh] grid-cols-1 grid-rows-[1fr_auto_1fr] bg-orange-50 lg:grid-cols-[max(50%,36rem)_1fr]"
        >
            <section
                class="mx-auto w-full max-w-7xl px-6 py-24 sm:py-32 lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:px-8"
            >
                <div class="max-w-lg">
                    <p class="text-base/8 font-semibold text-green-900">
                        {{ status }}
                    </p>
                    <h1
                        class="mt-4 text-pretty text-5xl font-semibold tracking-tight text-green-900 sm:text-6xl"
                    >
                        {{ message ?? 'Page introuvable' }}
                    </h1>
                    <p
                        class="mt-6 text-pretty text-lg font-medium text-green-900 sm:text-xl/8"
                    >
                        Nous sommes désolé, nous n'avons pas pu trouver la page
                        que vous recherchez.
                    </p>
                    <div class="mt-10">
                        <Link
                            :href="route('home')"
                            class="text-sm/7 font-semibold text-green-900"
                            ><span aria-hidden="true">&larr;</span> Retour à
                            l'accueil</Link
                        >
                    </div>
                </div>
            </section>
            <aside
                class="hidden lg:relative lg:col-start-2 lg:row-start-1 lg:row-end-4 lg:block"
            >
                <img
                    src="https://images.unsplash.com/photo-1470847355775-e0e3c35a9a2c?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1825&q=80"
                    alt=""
                    class="absolute inset-0 size-full object-cover"
                />
            </aside>
        </div>
    </AppLayout>
</template>

<style scoped></style>
