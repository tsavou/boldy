<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import Footer from '@/Layouts/Footer.vue';
import Header from '@/Layouts/Header.vue';
</script>

<template>
    <Header />
    <main
        class="flex min-h-[80vh] flex-col items-center bg-orange-50 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/">
                <div class="flex items-end gap-3">
                    <ApplicationLogo class="block h-20 w-auto" />
                    <img src="/img/boldy.png" alt="" class="h-14 w-auto" />
                </div>
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </main>
    <Footer />
</template>
