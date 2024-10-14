<script setup>
import { computed, onMounted, reactive, readonly, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Modal from "@/Components/DialogModal.vue";
import CustTextInput from "@/Components/CustTextInput.vue";
import axios from "axios";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
</script>
<template>
    <Head title="Product" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Order Data</h2>
                </div>
                <input
                    type="text"
                    placeholder="Search for..."
                    class="w-full mb-4 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring"
                />

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">No Order</th>
                            <th class="py-2 text-center">Product Name</th>
                            <th class="py-2 text-center">Customer</th>
                            <th class="py-2 text-center">SubTotal</th>
                            <th class="py-2 text-center">Total</th>
                            <th class="py-2 text-center">Status</th>
                            <th class="py-2 text-center">Pay</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </template>
    </AdminLayout>
</template>