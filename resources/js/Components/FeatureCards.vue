<template>
  <div class="max-w-7xl mx-auto p-8">
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
      <div
        v-for="(feature, index) in features"
        :key="index"
        class="bg-gray-50 rounded-lg p-6 text-center shadow-lg"
      >
        <!-- Icon -->
        <div class="flex justify-center mb-4">
          <img :src="feature.icon" alt="Feature Icon" class="w-12 h-12 text-blue-600" />
        </div>

        <!-- Title -->
        <h3 class="text-lg font-semibold text-gray-800">{{ feature.title }}</h3>

        <!-- Description -->
        <p class="text-gray-500 mt-2">{{ feature.description }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const features = [
  {
    icon: 'https://via.placeholder.com/48?text=📦', // Replace with your actual icon
    title: 'Product Packing',
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing.',
  },
  {
    icon: 'https://via.placeholder.com/48?text=🎧', // Replace with your actual icon
    title: '24x7 Support',
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing.',
  },
  {
    icon: 'https://via.placeholder.com/48?text=🚚', // Replace with your actual icon
    title: 'Delivery in 5 Days',
    description: 'Lorem ipsum dolor sit amet, consectetur adipisicing.',
  },
];
</script>

<style scoped>
/* Add custom styles if needed */
</style>
