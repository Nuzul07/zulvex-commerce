<template>
  <div class="max-w-7xl mx-auto p-8">
    <!-- Product Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div
        v-for="(product, index) in products"
        :key="index"
        class="relative bg-white rounded-lg p-4 shadow-lg hover:shadow-xl transition-shadow duration-200 cursor-pointer group"
        @click="openProductModal(product)"
      >
        <!-- Product Image -->
        <div class="relative">
          <img :src="product.image" alt="Product Image" class="w-full h-48 object-cover rounded-t-lg mb-4" />

          <!-- Remove from Wishlist (X) Button, shown only on hover -->
          <button 
            @click.stop="removeFromWishlist(index)" 
            class="absolute top-2 right-2 text-black hover:text-red-600 opacity-0 group-hover:opacity-100 transition-opacity"
          >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>

        <!-- Product Info -->
        <h3 class="text-lg font-medium">{{ product.name }}</h3>
        <p class="text-sm text-gray-400">{{ product.category }}</p>

        <!-- Rating -->
        <div class="flex items-center mt-2">
          <div class="flex space-x-1 text-yellow-500">
            <svg v-for="i in 5" :key="i" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-4 w-4">
              <path v-if="i <= product.rating" d="M12 .587l3.668 7.429 8.197 1.191-5.933 5.78 1.401 8.161L12 18.896l-7.333 3.852 1.401-8.161L.135 9.207l8.197-1.191z"/>
            </svg>
          </div>
          <span class="ml-2 text-gray-500">({{ product.rating }} stars)</span>
        </div>

        <!-- Price -->
        <div class="mt-2 text-lg font-semibold text-green-600">{{ product.price }}</div>
      </div>
    </div>

    <!-- Product Modal -->
    <div v-if="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
      <div class="bg-white rounded-lg p-8 w-full max-w-lg relative">
        <!-- Close Modal Button -->
        <button @click="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-red-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>

        <!-- Modal Content -->
        <div class="flex items-center">
          <!-- Modal Image -->
          <div class="w-1/2">
            <img :src="selectedProduct.image" alt="Product Image" class="w-full h-48 object-cover rounded-lg" />
          </div>

          <!-- Modal Info -->
          <div class="w-1/2 ml-4">
            <h2 class="text-xl font-semibold mb-2">{{ selectedProduct.name }}</h2>
            <p class="text-gray-500 mb-4">{{ selectedProduct.description }}</p>
            <div class="text-green-600 text-2xl font-bold">{{ selectedProduct.price }}</div>
            <div class="flex space-x-2 mt-4">
              <button class="bg-green-500 text-white px-6 py-2 rounded-lg">Add To Cart</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Sample products data
const products = ref([
  {
    name: 'Fresh Organic Villa Farm Lemon 500gm pack',
    category: 'Vegetables',
    price: '$120.25',
    rating: 4.5,
    image: 'https://via.placeholder.com/150x150?text=Lemon',
    description: 'Fresh organic villa farm lemon 500gm pack.',
  },
  {
    name: 'Best Snacks with Hazelnut Pack 200gm',
    category: 'Snacks',
    price: '$145',
    rating: 5,
    image: 'https://via.placeholder.com/150x150?text=Snacks',
    description: 'Best snacks with hazelnut pack 200gm.',
  },
  {
    name: 'Fresh Organic Apple 1kg Simla Marm',
    category: 'Fruits',
    price: '$120.25',
    rating: 4.5,
    image: 'https://via.placeholder.com/150x150?text=Apple',
    description: 'Fresh organic apple 1kg Simla Marm.',
  },
  {
    name: 'Organic Fresh Vanilla Farm Watermelon 5kg',
    category: 'Fruits',
    price: '$50.30',
    rating: 3.2,
    image: 'https://via.placeholder.com/150x150?text=Watermelon',
    description: 'Organic fresh vanilla farm watermelon 5kg.',
  },
]);

// Modal state
const showModal = ref(false);
const selectedProduct = ref({});

// Methods to handle product modal
function openProductModal(product) {
  selectedProduct.value = product;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
}

// Remove product from wishlist
function removeFromWishlist(index) {
  products.value.splice(index, 1);
}
</script>

<style scoped>
/* Add custom styles if necessary */
</style>
