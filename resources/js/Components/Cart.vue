<template>
  <div class="max-w-7xl mx-auto p-8">
    <!-- Cart Table -->
    <table class="w-full text-left border-collapse">
      <thead>
        <tr class="bg-gray-100">
          <th class="p-4 border-b-2">Product</th>
          <th class="p-4 border-b-2 text-center">Price</th>
          <th class="p-4 border-b-2 text-center">Quantity</th>
          <th class="p-4 border-b-2 text-center">Total</th>
          <th class="p-4 border-b-2 text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in cartItems" :key="index" class="border-t">
          <!-- Product Information -->
          <td class="p-4 flex items-center">
            <img :src="item.image" alt="Product Image" class="w-12 h-12 object-cover mr-4" />
            <span>{{ item.name }}</span>
          </td>
          
          <!-- Price -->
          <td class="p-4 text-center text-gray-700">
            ${{ item.price.toFixed(2) }}
          </td>

          <!-- Quantity -->
          <td class="p-4 text-center">
            <div class="flex items-center m-auto border rounded-lg w-max">
              <button @click="decreaseQuantity(item)" class="px-3 py-1">-</button>
              <input
                type="numeric"
                v-model="item.quantity"
                class="w-12 text-center border-l border-r"
                min="1"
              />
              <button @click="increaseQuantity(item)" class="px-3 py-1">+</button>
            </div>
          </td>

          <!-- Total -->
          <td class="p-4 text-center text-gray-700">
            ${{ (item.price * item.quantity).toFixed(2) }}
          </td>

          <!-- Remove Action -->
          <td class="p-4 text-center">
            <button @click="removeItem(index)" class="text-red-500 hover:text-red-700">
              <img class="m-auto" src="/storage/icon/trash.png" alt="Delete">
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Continue Shopping and Check Out Buttons -->
    <div class="flex justify-between mt-8">
      <button class="text-gray-500 hover:underline">
        Continue Shopping
      </button>
      <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
        Check Out
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Sample cart items data
const cartItems = ref([
  {
    name: 'Organic Lemon',
    price: 56.0,
    quantity: 1,
    image: 'https://via.placeholder.com/50x50?text=Lemon',
  },
  {
    name: 'Apple Juice',
    price: 75.0,
    quantity: 1,
    image: 'https://via.placeholder.com/50x50?text=Juice',
  },
  {
    name: 'Watermelon 5kg Pack',
    price: 48.0,
    quantity: 1,
    image: 'https://via.placeholder.com/50x50?text=Watermelon',
  },
  {
    name: 'Pomegranate 5 kg pack',
    price: 90.0,
    quantity: 1,
    image: 'https://via.placeholder.com/50x50?text=Pomegranate',
  },
  {
    name: 'Organic Peach Fruits',
    price: 50.0,
    quantity: 1,
    image: 'https://via.placeholder.com/50x50?text=Peach',
  },
]);

// Methods to handle quantity changes and item removal
function increaseQuantity(item) {
  item.quantity++;
}

function decreaseQuantity(item) {
  if (item.quantity > 1) {
    item.quantity--;
  }
}

function removeItem(index) {
  cartItems.value.splice(index, 1);
}
</script>

<style scoped>
/* Add custom styles if needed */
</style>
