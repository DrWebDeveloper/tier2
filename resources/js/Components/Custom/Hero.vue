<script setup>
import { ref } from 'vue';

const props = defineProps({
  industries: {
    type: Array,
    required: true
  },
  selectedIndustries: {
    type: Array,
    required: true
  }
});

const emit = defineEmits(['search-changed', 'industry-toggled']);

function onSearchInput(event) {
  const query = event.target.value;
  emit('search-changed', query);
}

function toggleIndustry(industryRid) {
  emit('industry-toggled', industryRid);
}
</script>

<template>
  <section class="hero-section">
    <div class="container">
      <div class="bg-customLightCream text-xs py-1 rounded-full mb-1 text-center max-w-xs mx-auto text-customBrown font-semibold">
        <span>Warning: This is a demo site 🔥</span>
      </div>
      <h1>Esports Organization Database</h1>
      <p>The only comprehensive, ever growing, esports organization directory tool</p>
      <div class="row justify-content-center hero-search mb-4">
        <div class="col-12 col-sm-8 col-md-6">
          <input
            type="text"
            class="form-control"
            placeholder="Search"
            aria-label="Search"
            @input="onSearchInput"
          >
        </div>
      </div>

      <div class="categories-filter">
        <!-- Use industry.rid for identification -->
        <button
          v-for="industry in industries"
          :key="industry.rid"
          :class="{
            'bg-customBrown text-white': selectedIndustries.includes(industry.rid),
            'bg-gray-200 text-black': !selectedIndustries.includes(industry.rid)
          }"
          @click="toggleIndustry(industry.rid)"
        >
          {{ industry.name }} ({{ industry.count }})
        </button>
      </div>
    </div>
  </section>
</template>

<style>
/* Your existing CSS */
</style>
