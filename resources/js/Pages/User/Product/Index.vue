<script setup>
import { computed, onMounted, reactive, readonly, ref, watch } from "vue";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Modal from "@/Components/DialogModal.vue";
import CustTextInput from "@/Components/CustTextInput.vue";
import axios from "axios";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import CustFileInput from "@/Components/CustFileInput.vue";
import CustImageDetail from "@/Components/CustImageDetail.vue";
import SearchInput from "@/Components/SearchInput.vue";
import UserLayout from "@/Layouts/UserLayout.vue";
import ProductCollection from "@/Components/ProductCollection.vue";
import NewArrivals from "@/Components/NewArrivals.vue";
import ProductDetailFull from "@/Components/ProductDetailFull.vue";

onMounted(() => {
    productData();
});

const product = ref([]);
const productLoading = ref(false);
const productData = async () => {
    productLoading.value = true;
    await axios.get(route("productAll")).then((res) => {
        const data = res.data;
        product.value = data;
        productLoading.value = false;
    });
};

const selectedProduct = ref(null);

const handleProductSelect = (product) => {
    selectedProduct.value = product;
};
</script>
<template>
    <Head title="Product" />
    <UserLayout>
        <template #content>
            <main class="flex-grow">
                <div class="max-w-7xl mx-auto py-10">
                    <!-- Pass the product data and the product selection handler -->
                    <NewArrivals
                        :products-data="product"
                        @product-selected="handleProductSelect"
                    />

                    <!-- Conditionally render ProductDetailFull if a product is selected -->
                    <ProductDetailFull
                        v-if="selectedProduct"
                        :product="selectedProduct"
                    />
                    <ProductCollection />
                </div>
            </main>
        </template>
    </UserLayout>
</template>
