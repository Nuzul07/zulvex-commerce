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
    voucherData();
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
    v_code: "",
    name: "",
    amount: "",
    expires_date: "",
    created_at: "",
    updated_at: "",
});

const detail = reactive({
    v_code: "",
    name: "",
    amount: "",
    expires_date: "",
    created_at: "",
    updated_at: "",
});

const modal = reactive({
    addVoucher: false,
    detailVoucher: false,
});

const modalAddVoucher = () => {
    modal.addVoucher = true;
};

const closeAddVoucher = () => {
    modal.addVoucher = false;
    resetInput();
};

const modalDetailVoucher = (d) => {
    modal.detailVoucher = true;
    selectDataVoucher(d);
};

const voucher = ref([]);
const voucherLoading = ref(false);
const voucherData = async () => {
    voucherLoading.value = true;
    await axios.get(route("voucherAll")).then((res) => {
        const data = res.data;
        voucher.value = data;
        voucherLoading.value = false;
    });
};

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(voucher.value.length / perPage));

const pgntVoucher = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchVoucher.value.length);
    return searchVoucher.value.slice(start, end).map((voucher, index) => ({
        ...voucher,
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

const searchIVoucher = ref("");
const searchVoucher = computed(() => {
    if (!searchIVoucher.value) {
        return voucher.value;
    }
    const lowerCase = searchIVoucher.value.toLowerCase();
    if (voucher.value) {
        return voucher.value.filter((vcr) => {
            return (
                vcr.v_code.toLowerCase().includes(lowerCase) ||
                vcr.name.toLowerCase().includes(lowerCase)
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

const selectDataVoucher = (d) => {
    input.v_code = d.v_code;
    input.name = d.name;
    input.amount = d.amount;
    input.expires_date = d.expires_date;
    input.created_at = formatDate(d.created_at);
    input.updated_at = formatDate(d.updated_at);

    //detail
    detail.v_code = d.v_code;
    detail.name = d.name;
    detail.amount = d.amount;
    detail.expires_date = d.expires_date;
    detail.created_at = d.created_at;
    detail.updated_at = d.updated_at;
};

const resetInput = () => {
    input.v_code = "";
    input.name = "";
    input.amount = "";
    input.expires_date = "";
    input.created_at = "";
    input.updated_at = "";
};

const store = async () => {
    try {
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        await axios.post(route("storeVoucher"), input);

        notyf.dismiss(loadingNotification);
        notyf.open({ type: "success", message: "Berhasil menambahkan voucher" });

        voucherData();
        modal.addVoucher = false;
        resetInput();
    } catch (error) {
        notyf.open({ type: "error", message: "Terjadi Kesalahan" });
        console.log(error);
    }
};

const update = async () => {
    try {
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0,
        });

        await axios.post(route("updateVoucher"), input);

        notyf.dismiss(loadingNotification);
        notyf.open({ type: "success", message: "Berhasil memperbarui voucher" });

        voucherData();
        modal.detailVoucher = false;
        resetInput();
    } catch (error) {
        notyf.open({ type: "error", message: "Terjadi Kesalahan" });
        console.log(error);
    }
};

const fieldMatch = ref(false);
watch([() => input.name, () => input.amount], ([newName, newAmount]) => {
    fieldMatch.value =
        newName === detail.name && newAmount === detail.amount ? true : false;
});
</script>
<template>
    <Head title="Voucher" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Voucher Data</h2>
                    <button
                        @click="modalAddVoucher"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600"
                    >
                        Add
                    </button>
                </div>
                <SearchInput
                    v-model="searchIVoucher"
                    placeholder="Voucher Code, Name"
                />

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">Code</th>
                            <th class="py-2 text-center">Name</th>
                            <th class="py-2 text-center">Amount</th>
                            <th class="py-2 text-center">Expires At</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!voucherLoading">
                        <tr
                            v-for="(d, index) in pgntVoucher"
                            :key="index"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ d.no }}</td>
                            <td class="py-2 text-center">{{ d.v_code }}</td>
                            <td class="py-2 text-center">{{ d.name }}</td>
                            <td class="py-2 text-center">
                                {{ formatRupiah(d.amount) }}
                            </td>
                            <td class="py-2 text-center">
                                {{ formatDate(d.expires_date) }}
                            </td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailVoucher(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail Voucher"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-md text-black"
                        v-if="voucherLoading"
                        >Sedang Memuat...</span
                    >
                </div>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-xl text-black"
                        v-if="!voucherLoading && voucher.length < 1"
                        >Tidak Ada Data</span
                    >
                </div>

                <!-- Modal Add Voucher -->
                <Modal
                    :show="modal.addVoucher"
                    @close="closeAddVoucher"
                    max-width="4xl"
                >
                    <template #title>Add Voucher</template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Voucher Name"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.name"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Voucher Amount"
                                    id="amount"
                                    type="text"
                                    name="amount"
                                    v-model="input.amount"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Expires At"
                                    id="expires_date"
                                    type="date"
                                    name="expires_date"
                                    v-model="input.expires_date"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.addVoucher = false"
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

                <!-- Modal Detail Voucher -->
                <Modal
                    :show="modal.detailVoucher"
                    @close="modal.detailVoucher = false"
                    maxWidth="4xl"
                >
                    <template #title> Detail Voucher #{{input.v_code}}</template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Voucher Name"
                                    id="name"
                                    type="text"
                                    name="name"
                                    v-model="input.name"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Voucher Amount"
                                    id="amount"
                                    type="text"
                                    name="amount"
                                    v-model="input.amount"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Expires At"
                                    id="expires_date"
                                    type="text"
                                    name="expires_date"
                                    v-model="input.expires_date"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Input Date"
                                    id="created_at"
                                    type="text"
                                    name="created_at"
                                    v-model="input.created_at"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Last Update"
                                    id="updated_at"
                                    type="text"
                                    name="updated_at"
                                    v-model="input.updated_at"
                                    :readonly="true"
                                    :required-indicator="false"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.detailVoucher = false"
                                        title="Close Modal"
                                        class="mt-7 ml-2 bg-red-700 text-white py-2 px-4 rounded"
                                    >
                                        Close
                                    </button>
                                    <button
                                        @click="update"
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
