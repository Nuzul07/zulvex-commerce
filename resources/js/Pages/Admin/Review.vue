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
    reviewData();
});

defineProps({
    errors: Object,
});

const detail = reactive({
    r_code: "",
    p_code: "",
    user_id: "",
    rate: "",
    description: "",
    created_at: "",
    updated_at: "",
});

const modal = reactive({
    detailReview: false,
});

const modalDetailReview = (d) => {
    modal.detailReview = true;
    selectDataReview(d);
};

const review = ref([]);
const reviewLoading = ref(false);
const reviewData = async () => {
    reviewLoading.value = true;
    await axios.get(route("reviewAll")).then((res) => {
        const data = res.data;
        review.value = data;
        reviewLoading.value = false;
    });
};

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(review.value.length / perPage));

const pgntReview = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchReview.value.length);
    return searchReview.value.slice(start, end).map((review, index) => ({
        ...review,
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

const searchIReview = ref("");
const searchReview = computed(() => {
    if (!searchIReview.value) {
        return review.value;
    }
    const lowerCase = searchIReview.value.toLowerCase();
    if (review.value) {
        return review.value.filter((rev) => {
            return (
                rev.adr_code.toLowerCase().includes(lowerCase) ||
                rev.province.toLowerCase().includes(lowerCase) ||
                rev.user_id.toLowerCase().includes(lowerCase)
            );
        });
    } else {
        return [];
    }
});

const formatDate = (date) => {
    const d = new Date(date);
    let month = "" + (d.getMonth() + 1);
    let day = "" + d.getDate();
    const year = d.getFullYear();

    if (month.length < 2) month = "0" + month;
    if (day.length < 2) day = "0" + day;

    return [day, month, year].join("-");
};

const selectDataReview = (d) => {
    detail.r_code = d.r_code;
    detail.p_code = d.p_code;
    detail.user_id = d.user_id;
    detail.rate = d.rate;
    detail.description = d.description;
    detail.created_at = formatDate(d.created_at);
    detail.updated_at = formatDate(d.updated_at);
};
</script>
<template>
    <Head title="Review" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Review Data</h2>
                </div>
                <SearchInput
                    v-model="searchIReview"
                    placeholder="Review Code, Rate"
                ></SearchInput>

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">Review Code</th>
                            <th class="py-2 text-center">Product Code</th>
                            <th class="py-2 text-center">User</th>
                            <th class="py-2 text-center">Rate</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!reviewLoading">
                        <tr
                            v-for="(d, index) in pgntReview"
                            :key="index"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ d.no }}</td>
                            <td class="py-2 text-center">{{ d.r_code }}</td>
                            <td class="py-2 text-center">{{ d.p_code }}</td>
                            <td class="py-2 text-center">{{ d.user_id }}</td>
                            <td class="py-2 text-center">{{ d.rate }}</td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailReview(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail Review"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-md text-black"
                        v-if="reviewLoading"
                        >Sedang Memuat...</span
                    >
                </div>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-xl text-black"
                        v-if="!reviewLoading && review.length < 1"
                        >Tidak Ada Data</span
                    >
                </div>

                <!-- Modal Detail Product -->
                <Modal
                    :show="modal.detailReview"
                    @close="modal.detailReview = false"
                    maxWidth="4xl"
                >
                    <template #title>
                        Detail Review #{{ detail.r_code }}</template
                    >
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Product Code"
                                    id="product"
                                    type="text"
                                    name="product"
                                    v-model="detail.p_code"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="User"
                                    id="user"
                                    type="text"
                                    name="user"
                                    v-model="detail.user"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Rate"
                                    id="rate"
                                    type="text"
                                    name="rate"
                                    v-model="detail.rate"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Description"
                                    id="description"
                                    type="text"
                                    name="description"
                                    v-model="detail.description"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Input Date"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="detail.created_at"
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
                                    v-model="detail.updated_at"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.detailReview = false"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
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
