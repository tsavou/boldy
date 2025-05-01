<script setup>
import Header from '@/Layouts/Header.vue';
import VerificationBanner from '@/Components/VerificationBanner.vue';
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
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
            <footer class="mt-4 bg-white shadow">footer</footer>
        </div>
    </div>
</template>
