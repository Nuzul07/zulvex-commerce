<template>
  <div class="max-w-7xl mx-auto p-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Summary Section -->
    <div class="lg:col-span-1">
      <div class="border p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Summary</h2>
        <div class="mb-4">
          <p class="flex justify-between">
            <span>Sub Total</span>
            <span>$80.00</span>
          </p>
          <p class="flex justify-between">
            <span>Delivery Charges</span>
            <span>$80.00</span>
          </p>
        </div>
        <hr class="my-4">
        <div class="flex justify-between font-bold">
          <span>Total Amount</span>
          <span>$80.00</span>
        </div>
        
        <!-- Products in Cart -->
        <div class="mt-6">
          <div class="flex items-center mb-4">
            <img src="https://via.placeholder.com/80" alt="Product 1" class="w-16 h-16 rounded mr-4">
            <div>
              <p class="font-semibold">Dates Value Pack Pouch</p>
              <p class="text-gray-500">$120.25 <span class="line-through">$123.25</span></p>
            </div>
          </div>
          <div class="flex items-center mb-4">
            <img src="https://via.placeholder.com/80" alt="Product 2" class="w-16 h-16 rounded mr-4">
            <div>
              <p class="font-semibold">Smoked Honey Spiced Nuts</p>
              <p class="text-gray-500">$120.25 <span class="line-through">$123.25</span></p>
            </div>
          </div>
        </div>
      </div>

      <!-- Delivery Method -->
      <div class="border p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-semibold mb-4">Delivery Method</h2>
        <div class="mb-4">
          <label class="flex items-center mb-2">
            <input type="radio" name="delivery" value="Free Shipping" class="mr-2">
            Free Shipping $0.00
          </label>
          <label class="flex items-center">
            <input type="radio" name="delivery" value="Flat Rate" class="mr-2">
            Flat Rate $5.00
          </label>
        </div>
        <textarea rows="3" placeholder="Add Comments About Your Order" class="w-full p-3 border rounded-lg focus:ring focus:border-green-500"></textarea>
      </div>

      <!-- Payment Method -->
      <div class="border p-6 rounded-lg shadow-lg mt-6">
        <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
        <div class="mb-4">
          <label class="flex items-center mb-2">
            <input type="radio" name="payment" value="Cash on Delivery" class="mr-2">
            Cash On Delivery
          </label>
          <label class="flex items-center mb-2">
            <input type="radio" name="payment" value="UPI" class="mr-2">
            UPI
          </label>
          <label class="flex items-center">
            <input type="radio" name="payment" value="Bank Transfer" class="mr-2">
            Bank Transfer
          </label>
        </div>
      </div>
    </div>

    <!-- Checkout Forms -->
    <div class="lg:col-span-1">
      <!-- New & Returning Customers -->
      <div class="border p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">New Customer</h2>
        <label class="block mb-4">
          <input type="radio" name="account_type" value="register" class="mr-2">
          Register Account
        </label>
        <label class="block mb-4">
          <input type="radio" name="account_type" value="guest" class="mr-2">
          Guest Account
        </label>
        <p class="text-gray-500 mb-4">By creating an account, you'll be able to shop faster, keep track of orders, and much more.</p>
        <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Continue</button>
      </div>

      <div class="border p-6 rounded-lg shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Returning Customer</h2>
        <input type="email" placeholder="Email Address" class="w-full p-3 border mb-4 rounded-lg focus:ring focus:border-green-500">
        <input type="password" placeholder="Password" class="w-full p-3 border mb-4 rounded-lg focus:ring focus:border-green-500">
        <div class="flex justify-between">
          <button class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Login</button>
          <a href="#" class="text-green-500">Forgot Password?</a>
        </div>
      </div>

      <!-- Billing Details -->
      <div class="border p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Billing Details</h2>
        <div class="mb-4">
          <label class="block mb-2">
            <input type="radio" name="billing_address" value="existing" class="mr-2">
            I want to use an existing address
          </label>
          <label class="block">
            <input type="radio" name="billing_address" value="new" class="mr-2">
            I want to use a new address
          </label>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <input type="text" placeholder="First Name" class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
          <input type="text" placeholder="Last Name" class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
        </div>
        <input type="text" placeholder="Address" class="w-full p-3 border mt-4 rounded-lg focus:ring focus:border-green-500">
        <div class="grid grid-cols-2 gap-4 mt-4">
          <input type="text" placeholder="City" class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
          <input type="text" placeholder="Post Code" class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
          <select class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
            <option value="" disabled selected>Country</option>
            <option>Country 1</option>
            <option>Country 2</option>
          </select>
          <select class="w-full p-3 border rounded-lg focus:ring focus:border-green-500">
            <option value="" disabled selected>Region/State</option>
            <option>State 1</option>
            <option>State 2</option>
          </select>
        </div>
        <button class="bg-green-500 text-white px-6 py-2 mt-6 rounded-lg hover:bg-green-600 w-full">Place Order</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';

// Data and methods (if any) can go here
</script>

<style scoped>
/* Custom styles (if needed) */
</style>
