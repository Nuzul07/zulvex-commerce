<script setup>
import { ref } from 'vue';
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
const orders = ref([
  { id: 1, orderId: 'TWT5015100365', customerName: 'Marie Prohaska', location: 'Germany', orderDate: '08 Jun, 2023', paymentMethod: 'Credit Card', quantity: 5, price: 146.99, totalAmount: 749.95 },
  { id: 2, orderId: 'TWT5015100366', customerName: 'Jaqueline Hammes', location: 'France', orderDate: '11 Jul, 2023', paymentMethod: 'Paypal', quantity: 2, price: 450.00, totalAmount: 900.00 },
  { id: 3, orderId: 'TWT5015100367', customerName: 'Marlene Hirthe', location: 'Argentina', orderDate: '21 Aug, 2023', paymentMethod: 'Visa Card', quantity: 3, price: 147.23, totalAmount: 294.46 },
  // Add more sample data as needed
]);

// Pagination
const displayedOrders = ref([...orders.value]);
const currentPage = ref(1);
const itemsPerPage = 7;
const totalPages = ref(Math.ceil(orders.value.length / itemsPerPage));

function setPage(page) {
  currentPage.value = page;
  updateDisplayedOrders();
}

function nextPage() {
  if (currentPage.value < totalPages.value) {
    currentPage.value++;
    updateDisplayedOrders();
  }
}

function prevPage() {
  if (currentPage.value > 1) {
    currentPage.value--;
    updateDisplayedOrders();
  }
}

function updateDisplayedOrders() {
  const start = (currentPage.value - 1) * itemsPerPage;
  const end = start + itemsPerPage;
  displayedOrders.value = orders.value.slice(start, end);
}

// Initialize displayed orders
updateDisplayedOrders();
</script>
<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Product Orders</h2>
                    <button
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                    >
                        Export
                    </button>
                </div>

                <input
                    type="text"
                    placeholder="Search for..."
                    class="w-full mb-4 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring"
                />

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2">#</th>
                            <th class="py-2">Order ID</th>
                            <th class="py-2">Customer Name</th>
                            <th class="py-2">Location</th>
                            <th class="py-2">Order Date</th>
                            <th class="py-2">Payments</th>
                            <th class="py-2">Quantity</th>
                            <th class="py-2">Price</th>
                            <th class="py-2">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(order, index) in orders"
                            :key="order.id"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2">{{ index + 1 }}</td>
                            <td class="py-2">{{ order.orderId }}</td>
                            <td class="py-2">{{ order.customerName }}</td>
                            <td class="py-2">{{ order.location }}</td>
                            <td class="py-2">{{ order.orderDate }}</td>
                            <td class="py-2">{{ order.paymentMethod }}</td>
                            <td class="py-2">{{ order.quantity }}</td>
                            <td class="py-2">${{ order.price.toFixed(2) }}</td>
                            <td class="py-2">
                                ${{ order.totalAmount.toFixed(2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <span
                        >Showing {{ displayedOrders.length }} of
                        {{ orders.length }} Results</span
                    >
                    <div class="flex space-x-2">
                        <button
                            @click="prevPage"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg"
                        >
                            Prev
                        </button>
                        <button
                            v-for="page in totalPages"
                            :key="page"
                            @click="setPage(page)"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg"
                        >
                            {{ page }}
                        </button>
                        <button
                            @click="nextPage"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </AdminLayout>
</template>
