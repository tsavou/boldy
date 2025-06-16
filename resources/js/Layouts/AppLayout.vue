<script setup>
import { Head } from '@inertiajs/vue3';
import Header from '@/Layouts/Header.vue';
import VerificationBanner from '@/Components/VerificationBanner.vue';
import Footer from '@/Layouts/Footer.vue';
</script>

<template>
    <div>
        <Head>
            <meta
                name="description"
                content="Découvrez Boldy, la plateforme pour freelances digitaux. Personnalisez et valorisez votre profil, booster votre visibilité et trouvez des opportunités de collaboration."
            />
            <meta
                name="keywords"
                content="freelance, développeur, plateforme, visibilité, profil, tech, remote, boldy, freelance platform, developer, tech freelance, digital"
            />
            <meta name="author" content="Théo Savourat" />
            <meta name="robots" content="index, follow" />

            <meta property="og:title" content="Boldy – Plateforme freelance" />
            <meta
                property="og:description"
                content="Centralisez et valorisez votre profil freelance sur Boldy."
            />
            <meta property="og:image" content="/images/social-banner.jpg" />
            <meta property="og:url" content="https://boldy.laravel.cloud/" />
            <meta property="og:type" content="website" />
        </Head>
        <div class="min-h-screen bg-orange-50">
            <Header />

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>

            <!-- Page Alerts -->

            <VerificationBanner
                v-if="$page.props.auth.user"
                :isEmailVerified="
                    $page.props.auth.user.email_verified_at !== null
                "
                :isFreelanceVerified="
                    !!$page.props.auth.user.freelance.is_verified
                "
            />
            <!-- Page Footer -->
            <Footer />
        </div>
    </div>
</template>
