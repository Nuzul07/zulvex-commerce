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
    paymentData();
});

defineProps({
    errors: Object,
});

const detail = reactive({
    payment_code: "",
    no_invoice: "",
    user_id: "",
    total: "",
    payment_type: "",
    created_at: "",
    updated_at: "",
});

const modal = reactive({
    detailPayment: false,
});

const modalDetailPayment = (d) => {
    modal.detailPayment = true;
    selectDataPayment(d);
};

const payment = ref([]);
const paymentLoading = ref(false);
const paymentData = async () => {
    paymentLoading.value = true;
    await axios.get(route("paymentAll")).then((res) => {
        const data = res.data;
        payment.value = data;
        paymentLoading.value = false;
    });
};

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(payment.value.length / perPage));

const pgntPayment = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchPayment.value.length);
    return searchPayment.value.slice(start, end).map((payment, index) => ({
        ...payment,
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

const searchIPayment = ref("");
const searchPayment = computed(() => {
    if (!searchIPayment.value) {
        return payment.value;
    }
    const lowerCase = searchIPayment.value.toLowerCase();
    if (payment.value) {
        return payment.value.filter((pay) => {
            return (
                pay.adr_code.toLowerCase().includes(lowerCase) ||
                pay.province.toLowerCase().includes(lowerCase) ||
                pay.user_id.toLowerCase().includes(lowerCase)
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

const selectDataPayment = (d) => {
    detail.payment_code = d.payment_code;
    detail.no_invoice = d.no_invoice;
    detail.user_id = d.user_id;
    detail.total = d.total;
    detail.payment_type = d.payment_type;
    detail.created_at = formatDate(d.created_at);
    detail.updated_at = formatDate(d.updated_at);
};
</script>
<template>
    <Head title="Payments" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Payment Data</h2>
                </div>
                <SearchInput
                    v-model="searchIPayment"
                    placeholder="Payment Code, No Invoice, Buyer"
                ></SearchInput>

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">Payment Code</th>
                            <th class="py-2 text-center">No Invoice</th>
                            <th class="py-2 text-center">Buyer</th>
                            <th class="py-2 text-center">Total</th>
                            <th class="py-2 text-center">Payment Type</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!paymentLoading">
                        <tr
                            v-for="(d, index) in pgntPayment"
                            :key="index"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ d.no }}</td>
                            <td class="py-2 text-center">
                                {{ d.payment_code }}
                            </td>
                            <td class="py-2 text-center">{{ d.no_invoice }}</td>
                            <td class="py-2 text-center">{{ d.user_id }}</td>
                            <td class="py-2 text-center">{{ d.total }}</td>
                            <td class="py-2 text-center">
                                {{ d.payment_type }}
                            </td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailPayment(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail Payment"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-md text-black"
                        v-if="paymentLoading"
                        >Sedang Memuat...</span
                    >
                </div>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-xl text-black"
                        v-if="!paymentLoading && payment.length < 1"
                        >Tidak Ada Data</span
                    >
                </div>

                <!-- Modal Detail Product -->
                <Modal
                    :show="modal.detailPayment"
                    @close="modal.detailPayment = false"
                    maxWidth="4xl"
                >
                    <template #title>
                        Detail Payment #{{ detail.payment_code }}</template
                    >
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Payment Code"
                                    id="payment_code"
                                    type="text"
                                    name="payment_code"
                                    v-model="detail.payment_code"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="No Invoice"
                                    id="no_invoice"
                                    type="text"
                                    name="no_invoice"
                                    v-model="detail.no_invoice"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Buyer"
                                    id="buyer"
                                    type="text"
                                    name="buyer"
                                    v-model="detail.buyer"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Total"
                                    id="total"
                                    type="text"
                                    name="total"
                                    v-model="detail.total"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Payment Type"
                                    id="payment_type"
                                    type="text"
                                    name="payment_type"
                                    v-model="detail.payment_type"
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
                                        @click="modal.detailPayment = false"
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
