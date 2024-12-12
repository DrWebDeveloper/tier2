<script setup>
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome" />

</template>
<style scoped>
*{
    font-family: 'Inter', sans-serif !important;
}
body {
    background-color: #FFFFFF;
    color: #000000;
}

/* Navbar */
.navbar-brand {
    font-weight: 600;
    letter-spacing: -0.5px;
}

.navbar-nav .nav-link {
    font-weight: 500;
    color: #000000;
}

.navbar-nav .nav-link:hover {
    color: #6c757d;
}

.btn-add-listing {
    background-color: #ac7339;
    color: #ffffff;
    font-weight: 500;
    border-radius: 4px;
    padding: 0.5rem 1rem;
    text-decoration: none;
}

.btn-add-listing:hover {
    background-color: #945f2a;
    color: #fff;
}

/* Hero Section */
.hero-section {
    text-align: center;
    padding: 4rem 1rem;
}

.hero-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-section p {
    font-size: 1.125rem;
    color: #555555;
    margin-bottom: 2rem;
}

.hero-search .form-control {
    border: 1px solid #ddd;
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
}

.categories-filter {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

.categories-filter button {
    background-color: #f5f5f5;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #333;
    cursor: pointer;
}

.categories-filter button:hover {
    background-color: #ebebeb;
}

/* Results Section */
.results-count {
    font-weight: 600;
    margin-bottom: 2rem;
}

.tool-card {
    border: 1px solid #eee;
    border-radius: 8px;
    padding: 1.5rem;
    text-align: left;
    position: relative;
    transition: box-shadow 0.3s;
    height: 100%;
}

.tool-card:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}

.featured-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background-color: #ffe9cc;
    color: #ac7339;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
}

.tool-card h5 {
    margin-bottom: 0.5rem;
    font-weight: 600;
    font-size: 1.125rem;
}

.tool-card p {
    font-size: 0.9rem;
    color: #555;
    margin-bottom: 2rem;
}

.tool-card .bookmark-btn {
    position: absolute;
    bottom: 1rem;
    right: 1rem;
    background: none;
    border: none;
    cursor: pointer;
}

.tool-card .bookmark-btn::before {
    content: '🔖';
    /* Replace with an icon if desired */
    font-size: 1.25rem;
}

/* Category Filter on Right (if needed) */
.category-select {
    margin-bottom: 2rem;
    max-width: 200px;
}

/* Footer */
footer {
    text-align: center;
    padding: 2rem 0;
    font-size: 0.875rem;
    color: #777;
}

@media (min-width: 992px) {
    .hero-section h1 {
        font-size: 3rem;
    }
}
</style>
