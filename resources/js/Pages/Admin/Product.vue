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

onMounted(() => {
    productData();
});

defineProps({
    errors: Object,
});

const notyf = new Notyf({
    position: {
        x: "right",
        y: "top",
    },
    types: [
        {
            type: "info",
            background: "blue",
            duration: 1000,
        },
        {
            type: "success",
            background: "green",
            duration: 2500,
        },
        {
            type: "error",
            background: "red",
            duration: 3000,
        },
    ],
});

const input = reactive({
    p_code: "",
    name: "",
    title: "",
    color: "",
    price: "",
    phone_type: "",
    stock: "",
    description: "",
    image: [],
    created_at: "",
    updated_at: "",
});

const detail = reactive({
    p_code: "",
    name: "",
    title: "",
    color: "",
    price: "",
    phone_type: "",
    stock: "",
    description: "",
    image: [],
});

const modal = reactive({
    addProduct: false,
    detailProduct: false,
});

const modalAddProduct = () => {
    modal.addProduct = true;
};

const closeAddProduct = () => {
    modal.addProduct = false;
    resetInput();
};

const modalDetailProduct = (d) => {
    modal.detailProduct = true;
    selectDataProduct(d);
};

const closeDetailProduct = () => {
    modal.detailProduct = false;
    resetInput();
};

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

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(product.value.length / perPage));

const pgntProduct = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchProduct.value.length);
    return searchProduct.value.slice(start, end).map((product, index) => ({
        ...product,
        no: start + index + 1,
    }));
});

const prevPage = () => {
    if (crntPage.value > 1) {
        crntPage.value--;
    }
};

const nextPage = () => {
    if (crntPage.value < totalPages.value) {
        crntPage.value++;
    }
};

const searchIProduct = ref("");
const searchProduct = computed(() => {
    if (!searchIProduct.value) {
        return product.value;
    }
    const lowerCase = searchIProduct.value.toLowerCase();
    if (product.value) {
        return product.value.filter((prd) => {
            return (
                prd.p_code.toLowerCase().includes(lowerCase) ||
                prd.name.toLowerCase().includes(lowerCase) ||
                prd.phone_type.toLowerCase().includes(lowerCase)
            );
        });
    } else {
        return [];
    }
});

//formatter
const formatDate = (date) => {
    const d = new Date(date);
    let month = "" + (d.getMonth() + 1);
    let day = "" + d.getDate();
    const year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [day, month, year].join("-");
};

const formatRupiah = (value) => {
    const numberFormat = new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0, // No decimal places
        maximumFractionDigits: 0, // No decimal places
    });
    return numberFormat.format(value);
};

const selectDataProduct = (d) => {
    input.p_code = d.p_code;
    input.name = d.name;
    input.title = d.title;
    input.color = d.color;
    input.price = d.price;
    input.phone_type = d.phone_type;
    input.stock = d.stock;
    input.description = d.description;
    input.image = JSON.parse(d.image);
    input.created_at = formatDate(d.created_at);
    input.updated_at = formatDate(d.updated_at);

    //detail
    detail.p_code = d.p_code;
    detail.name = d.name;
    detail.title = d.title;
    detail.color = d.color;
    detail.price = d.price;
    detail.phone_type = d.phone_type;
    detail.stock = d.stock;
    detail.description = d.description;
    detail.image = JSON.parse(d.image);
};

const resetInput = () => {
    input.p_code = "";
    input.name = "";
    input.color = "";
    input.price = "";
    input.phone_type = "";
    input.stock = "";
    input.title = "";
    input.description = "";
    input.image = [];
};

const store = async () => {
    const formData = new FormData();

    // Append regular fields
    formData.append("p_code", input.p_code);
    formData.append("name", input.name);
    formData.append("title", input.title);
    formData.append("color", input.color);
    formData.append("price", input.price);
    formData.append("phone_type", input.phone_type);
    formData.append("stock", input.stock);
    formData.append("description", input.description);

    // Append image files to formData
    input.image.forEach((file, index) => {
        formData.append(`image[${index}]`, file); // `image` field in formData
    });

    try {
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        await axios.post(route("storeProduct"), formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        notyf.dismiss(loadingNotification);
        notyf.open({ type: "success", message: "Berhasil menambah produk" });

        // Clear or reload data after success
        productData(); // Refresh product data
        modal.addProduct = false;
        resetInput();
    } catch (error) {
        notyf.open({ type: "error", message: "Terjadi Kesalahan" });
        console.log(error);
    }
};

const fieldMatch = ref(false);
watch(
    [
        () => input.name,
        () => input.color,
        () => input.price,
        () => input.phone_type,
        () => input.stock,
        () => input.title,
        () => input.description,
    ],
    ([newName, newColor, newPrice, newType, newStock, newTitle, newDesc]) => {
        fieldMatch.value =
            newName === detail.name &&
            newColor === detail.color &&
            newPrice === detail.price &&
            newType === detail.phone_type &&
            newStock === detail.stock &&
            newTitle === detail.title &&
            newDesc === detail.description
                ? true
                : false;
    }
);
</script>
<template>
    <Head title="Product" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Product Data</h2>
                    <button
                        @click="modalAddProduct()"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                    >
                        Add
                    </button>
                </div>
                <SearchInput
                    v-model="searchIProduct"
                    placeholder="Product ID, Name, Phone Type"
                ></SearchInput>

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">Product ID</th>
                            <th class="py-2 text-center">Name</th>
                            <th class="py-2 text-center">Color</th>
                            <th class="py-2 text-center">Phone Type</th>
                            <th class="py-2 text-center">Stock</th>
                            <th class="py-2 text-center">Price</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!productLoading">
                        <tr
                            v-for="(d, index) in pgntProduct"
                            :key="index"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ d.no }}</td>
                            <td class="py-2 text-center">{{ d.p_code }}</td>
                            <td class="py-2 text-center">{{ d.name }}</td>
                            <td class="py-2 text-center">{{ d.color }}</td>
                            <td class="py-2 text-center">{{ d.phone_type }}</td>
                            <td class="py-2 text-center">{{ d.stock }}</td>
                            <td class="py-2 text-center">
                                {{ formatRupiah(d.price) }}
                            </td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailProduct(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail Product"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-md text-black"
                        v-if="productLoading"
                        >Sedang Memuat...</span
                    >
                </div>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-xl text-black"
                        v-if="!productLoading && product.length < 1"
                        >Tidak Ada Data</span
                    >
                </div>

                <!-- Modal Add Product -->
                <Modal
                    :show="modal.addProduct"
                    @close="closeAddProduct"
                    maxWidth="4xl"
                >
                    <template #title> Add Product </template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Product Name"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.name"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Color"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.color"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Phone Type"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.phone_type"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Price"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.price"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Stock"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.stock"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Title"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.title"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Description"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.description"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustFileInput
                                    label="Photo"
                                    :requiredIndicator="true"
                                    :multiple="true"
                                    v-model="input.image"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.addProduct = false"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
                                    </button>
                                    <button
                                        @click="store"
                                        title="Submit"
                                        class="mt-7 ml-2 bg-green-700 text-white py-2 px-4 rounded"
                                    >
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>

                <!-- Modal Detail Product -->
                <Modal
                    :show="modal.detailProduct"
                    @close="modal.detailProduct = false"
                    maxWidth="4xl"
                >
                    <template #title> Detail Product #{{input.p_code}}</template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Product Name"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.name"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Color"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.color"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Phone Type"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.phone_type"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Price"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.price"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Stock"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.stock"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Title"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.title"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Description"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.description"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Input Date"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.created_at"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Last Update"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.updated_at"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                            <div
                                class="sm:col-span-1"
                                v-for="(d, index) in input.image"
                                :key="index"
                            >
                                <CustImageDetail
                                    :label="`Photo ${index + 1}`"
                                    :folder="`productPhoto/${input.p_code}`"
                                    :image="d"
                                    :required-indicator="false"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="closeDetailProduct"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
                                    </button>
                                    <button
                                        @click=""
                                        :disabled="fieldMatch"
                                        :class="{ hidden: fieldMatch }"
                                        :title="
                                            fieldMatch
                                                ? 'You dont changed any data'
                                                : 'Click to update data'
                                        "
                                        class="mt-7 ml-2 bg-green-700 text-white py-2 px-4 rounded"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </Modal>
            </div>
        </template>
    </AdminLayout>
</template>
