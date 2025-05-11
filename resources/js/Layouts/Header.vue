<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import Dropdown from '@/Components/Dropdown.vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

const showingNavigationDropdown = ref(false);

const user = computed(() => usePage().props.auth.user);

const logout = () => {
    router.post(route('logout'), {
        onSuccess: () => {
            router.visit(route('home'));
        },
    });
};
</script>

<template>
    <header role="banner" class="sticky top-0 z-50">
        <nav class="bg-green-900 text-orange-50">
            <!-- Primary Navigation Menu -->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('home')">
                                <div class="flex items-end gap-3">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current"
                                    />
                                    <img
                                        src="/img/boldy.png"
                                        alt=""
                                        class="h-7"
                                    />
                                </div>
                            </Link>
                        </div>

                        <!-- Navigation Links -->
                        <div
                            class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                        >
                            <NavLink
                                :href="route('home')"
                                :active="route().current('home')"
                            >
                                Accueil
                            </NavLink>
                            <NavLink
                                :href="route('freelance.index')"
                                :active="route().current('freelance.index')"
                            >
                                Freelances
                            </NavLink>
                        </div>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <!-- Settings Dropdown -->
                        <div class="relative ms-3 sm:flex sm:items-center">
                            <Dropdown v-if="user" align="right" width="48" content-classes="bg-green-900">
                                <template #trigger>
                                    <span
                                        class="inline-flex items-center rounded-full"
                                    >
                                        <button
                                            type="button"
                                            class="flex items-center rounded-full bg-lime-300 pr-1 text-sm text-green-900 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                                        >
                                            <img
                                                :src="
                                                    user.freelance
                                                        .profile_picture ||
                                                    '/img/default_avatar.jpg'
                                                "
                                                :alt="`photo de profil de ${user.first_name} ${user.name}`"
                                                class="h-10 w-10 rounded-full object-cover"
                                            />
                                            <span
                                                class="ms-2 font-bold text-green-900"
                                            >
                                                {{ user.first_name }}</span
                                            >

                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <DropdownLink
                                        v-if="user"
                                        :href="
                                            route(
                                                'freelance.show',
                                                user.freelance.slug,
                                            )
                                        "
                                        :active="
                                            route().current(
                                                'freelance.show',
                                                user.freelance.slug,
                                            )
                                        "
                                    >
                                        Mon profil
                                    </DropdownLink>
                                    <DropdownLink :href="route('profile.edit')">
                                        Mon compte
                                    </DropdownLink>
                                    <DropdownLink
                                        @click="logout"
                                        method="post"
                                        as="button"
                                    >
                                        Déconnexion
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                            <template v-else>
                                <div class="space-x-4">
                                    <Link
                                        :href="route('login')"
                                        class="inline-flex items-center rounded-md border border-orange-50 bg-green-900 px-3 py-2 text-sm font-medium leading-4 text-orange-50 transition duration-150 ease-in-out hover:bg-orange-50 hover:text-green-900 focus:outline-none"
                                    >
                                        Connexion
                                    </Link>

                                    <Link
                                        :href="route('register')"
                                        class="inline-flex items-center rounded-md border border-transparent bg-orange-50 px-3 py-2 text-sm font-medium leading-4 text-green-900 transition duration-150 ease-in-out hover:border-orange-50 hover:bg-green-900 hover:text-orange-50 focus:outline-none"
                                    >
                                        Rejoindre Boldy
                                    </Link>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            class="inline-flex items-center justify-center rounded-md p-2 text-lime-300 transition duration-150 ease-in-out focus:outline-none"
                        >
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div
                :class="{
                    block: showingNavigationDropdown,
                    hidden: !showingNavigationDropdown,
                }"
                class="fixed left-0 right-0 z-40 bg-green-900 sm:hidden"
            >
                <div class="space-y-1 pb-3 pt-2">
                    <ResponsiveNavLink
                        :href="route('home')"
                        :active="route().current('home')"
                    >
                        Accueil
                    </ResponsiveNavLink>
                    <ResponsiveNavLink
                        :href="route('freelance.index')"
                        :active="route().current('freelance.index')"
                    >
                        Freelances
                    </ResponsiveNavLink>
                </div>

                <!-- Responsive Settings Options -->
                <div class="border-t border-gray-200 pb-1 pt-4">
                    <div v-if="user" class="space-y-1">
                        <ResponsiveNavLink
                            v-if="user"
                            :href="route('freelance.show', user.freelance.slug)"
                            :active="
                                route().current(
                                    'freelance.show',
                                    user.freelance.slug,
                                )
                            "
                        >
                            Mon profil
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('profile.edit')"
                            :active="route().current('profile.edit')"
                        >
                            Mon compte
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            @click="logout"
                            method="post"
                            as="button"
                        >
                            Déconnexion
                        </ResponsiveNavLink>
                    </div>
                    <div v-else>
                        <div class="space-y-1">
                            <ResponsiveNavLink
                                :href="route('login')"
                                :active="route().current('login')"
                            >
                                Connexion
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('register')"
                                :active="route().current('register')"
                            >
                                Rejoindre Boldy
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</template>
