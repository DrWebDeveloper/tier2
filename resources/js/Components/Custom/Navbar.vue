<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link } from '@inertiajs/vue3';

</script>
<template>
        <nav class="navbar navbar-expand-lg navbar-light border-bottom bg-white">
        <div class="container">
            <Link class="navbar-brand" :href="route('home')"><img src="/.././assets/images/logo.png" alt="search" class="w-[100px] h-4 me-3"></Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-lg-0 align-items-center mb-2 ms-auto">
                    <!-- <li class="nav-item">
                        <a class="nav-link me-3" href="#">Blog</a>
                    </li> -->
                    <li class="nav-item">
                         <Link :class="{ 'font-semibold me-3': true,'text-customBrown': route().current('home') }" :href="route('home')">Home</Link>
                    </li>
                    <li class="nav-item">
                         <Link :class="{ 'font-semibold me-3': true,'text-customBrown': route().current('sponsorships') }" :href="route('sponsorships')">Sponsors</Link>
                    </li>
                    <li class="nav-item">
                        <a class="font-semibold me-3" href="#">Contact Us</a>
                    </li>
                    <!-- <li class="nav-item me-3">
                        <a class="nav-link" href="#">Login</a>
                    </li> -->
                    <li class="nav-item">
                        <PrimaryButton class="font-semibold bg-customBrown">+Add Listing</PrimaryButton>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
