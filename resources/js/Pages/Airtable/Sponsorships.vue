<script setup>
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Navbar from '@/Components/Custom/Navbar.vue';
import Hero from '@/Components/Custom/Hero.vue';
import Footer from '@/Components/Custom/Footer.vue';

const props = defineProps({
    industries: {
        type: Array,
        required: true
    },
    sponsorships: {
        type: Array,
        required: true
    }
});

const industries = props.industries;
const sponsorships = props.sponsorships;

const searchQuery = ref('');
// This will store selected industry rids (not ids)
const selectedIndustries = ref([]);

// Filter by search query first
const filteredBySearch = computed(() => {
    const query = searchQuery.value.toLowerCase();
    if (!query) return sponsorships;

    return sponsorships.filter(sponsorship =>
        sponsorship.name.toLowerCase().includes(query)
    );
});

// Filter by selected industries
const filteredSponsorships = computed(() => {
    const filtered = filteredBySearch.value;

    // If no industries selected, return all from the search result
    if (selectedIndustries.value.length === 0) {
        return filtered;
    }

    // Return sponsorships whose industry_rid is in selectedIndustries
    return filtered.filter(sponsorship => {
        return selectedIndustries.value.includes(sponsorship.industry_rid);
    });
});

// Compute dynamic counts based on the search results for each industry
const industriesWithCounts = computed(() => {
    return industries.map(industry => {
        // Count how many sponsorships in filteredBySearch belong to this industry.rid
        const filteredCount = filteredBySearch.value.filter(sponsorship => {
            return sponsorship.industry_rid === industry.rid;
        }).length;

        return {
            ...industry,
            count: filteredCount
        };
    });
});

// Handlers
function handleSearchChanged(query) {
    searchQuery.value = query;
}

function handleIndustryToggled(industryRid) {
    const index = selectedIndustries.value.indexOf(industryRid);
    if (index === -1) {
        selectedIndustries.value.push(industryRid);
    } else {
        selectedIndustries.value.splice(index, 1);
    }
}
</script>

<template>
    <Head title="Welcome" />
    <Navbar />

    <Hero
      :industries="industriesWithCounts"
      :selected-industries="selectedIndustries"
      @search-changed="handleSearchChanged"
      @industry-toggled="handleIndustryToggled"
    />

    <!-- {{ organizations }} -->

    <section class="results-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="results-count">{{ filteredSponsorships.length }} Results</div>
            </div>

            <div class="row g-3">
                <div class="col-12 col-sm-6 col-md-4 col-lg-3"
                     v-for="sponsorship in filteredSponsorships"
                     :key="sponsorship.id">
                    <div class="tool-card border-2">
                        <h5 class="border-b-2">{{ sponsorship.name }}</h5>
                        <p>Sponsors:</p>
                        <img :src="JSON.parse(sponsorship.logo)[0]?.url"
                             :alt="sponsorship.name"
                             style="width: 100%; height: 100px;">
                        <p></p>
                        <a class="w-full justify-center inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
                           :href="sponsorship.website"
                           target="_blank">
                            Visit Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>


<style>
* {
    /* font-family: 'Inter', sans-serif !important; */
    font-family: "Outfit", sans-serif;

}

body {
    background-color: #FFFFFF;
    color: #000000;
}

/* Navbar */
.navbar-brand {
    font-family: "DM Serif Text";
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
    font-family: "DM Serif Text";
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.hero-section p {
    font-family: "Playfair Display", serif;
    font-size: 1.125rem;
    font-weight: 700;
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
    /* background-color: #f5f5f5; */
    border: none;
    padding: 0.3rem 1rem;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #333;
    cursor: pointer;
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
