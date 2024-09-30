<template>
  <div class="max-w-7xl mx-auto p-8">
    <!-- Page Title -->
    <div class="text-center mb-12">
      <h2 class="text-3xl font-semibold">Get in Touch</h2>
      <p class="text-gray-500 mt-2">Prepared is me marianne pleasure likewise debating. Wonder an unable except better stairs do ye admire. His secure called esteem praise.</p>
    </div>

    <!-- Contact Info Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
      <!-- Contact Info Card 1: Contact -->
      <div class="border p-6 rounded-lg shadow-lg text-center">
        <div class="flex justify-center mb-4 text-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M4 6h16M5 14h14m1 6H4m-1-2v-2" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Contact</h3>
        <p class="text-gray-500">(+91)-987654XXXX</p>
        <p class="text-gray-500">(+91)-876543XXXX</p>
      </div>

      <!-- Contact Info Card 2: Mail & Website -->
      <div class="border p-6 rounded-lg shadow-lg text-center">
        <div class="flex justify-center mb-4 text-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 10l-4-4m0 0L8 10m4-4v12" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Mail & Website</h3>
        <p class="text-gray-500">mail.example@gmail.com</p>
        <p class="text-gray-500">www.yourdomain.com</p>
      </div>

      <!-- Contact Info Card 3: Address -->
      <div class="border p-6 rounded-lg shadow-lg text-center">
        <div class="flex justify-center mb-4 text-yellow-600">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />
          </svg>
        </div>
        <h3 class="text-lg font-semibold mb-2">Address</h3>
        <p class="text-gray-500">140 Ruaim Moraes Filho, 957</p>
        <p class="text-gray-500">Salvador - MA, 40352, Brazil</p>
      </div>
    </div>

    <!-- Map and Contact Form Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Map Section -->
      <div>
        <iframe
          class="w-full h-80 rounded-lg shadow-lg"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345093717!2d144.95373531531696!3d-37.817209979751885!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf5775e858d099b1!2sFlinders%20Street%20Station!5e0!3m2!1sen!2sau!4v1617263866575!5m2!1sen!2sau"
          allowfullscreen=""
          loading="lazy"
        ></iframe>
      </div>

      <!-- Contact Form Section -->
      <div>
        <form @submit.prevent="submitForm" class="space-y-4">
          <div>
            <input
              type="text"
              v-model="form.fullName"
              placeholder="Full Name"
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-yellow-500"
            />
          </div>
          <div>
            <input
              type="email"
              v-model="form.email"
              placeholder="Email"
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-yellow-500"
            />
          </div>
          <div>
            <input
              type="tel"
              v-model="form.phone"
              placeholder="Phone"
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-yellow-500"
            />
          </div>
          <div>
            <textarea
              v-model="form.message"
              placeholder="Message"
              rows="5"
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-yellow-500"
            ></textarea>
          </div>
          <button type="submit" class="w-full bg-yellow-500 text-white p-3 rounded-lg hover:bg-yellow-600">Submit</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
  fullName: '',
  email: '',
  phone: '',
  message: '',
});

function submitForm() {
  console.log('Form Submitted:', form.value);
  // You can handle form submission here (e.g., send the data to your backend)
}
</script>

<style scoped>
/* Custom styles if necessary */
</style>
