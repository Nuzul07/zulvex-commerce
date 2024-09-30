<template>
  <div class="max-w-6xl mx-auto p-8">
    <div class="grid grid-cols-5 gap-6">
      <div
        v-for="(category, index) in categories"
        :key="index"
        class="bg-gray-200 rounded-lg p-6 text-center shadow-md"
      >
        <div class="relative flex justify-center items-center mb-4">
          <!-- Circle with Icon -->
          <div class="w-16 h-16 bg-opacity-20 rounded-full flex items-center justify-center"
            :class="category.bgColor"
          >
            <img :src="category.icon" alt="Category Icon" class="w-8 h-8" />
          </div>
        </div>
        <!-- Category Name -->
        <h3 class="text-lg font-semibold text-gray-800">{{ category.name }}</h3>
        <!-- Item Count -->
        <p class="text-gray-500">{{ category.items }} Items</p>
      </div>
    </div>
  </div>
</template>

<script setup>
const categories = [
  {
    name: 'Shirt',
    items: 67,
    icon: 'https://via.placeholder.com/24?text=S', // Replace with your actual icon
    bgColor: 'bg-red-100',
  },
  {
    name: 'Hats',
    items: 81,
    icon: 'https://via.placeholder.com/24?text=H', // Replace with your actual icon
    bgColor: 'bg-yellow-100',
  },
  {
    name: 'Boot',
    items: 32,
    icon: 'https://via.placeholder.com/24?text=B', // Replace with your actual icon
    bgColor: 'bg-green-100',
  },
  {
    name: 'Tops',
    items: 78,
    icon: 'https://via.placeholder.com/24?text=T', // Replace with your actual icon
    bgColor: 'bg-pink-100',
  },
  {
    name: 'Vest',
    items: 64,
    icon: 'https://via.placeholder.com/24?text=V', // Replace with your actual icon
    bgColor: 'bg-purple-100',
  },
];
</script>

<style scoped>
/* Custom styles if necessary */
</style>
