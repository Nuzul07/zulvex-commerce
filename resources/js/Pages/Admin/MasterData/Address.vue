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
    addressData();
});

defineProps({
    errors: Object,
});

const detail = reactive({
    adr_code: "",
    user_id: "",
    province: "",
    city: "",
    district: "",
    neighborhood: "",
    zipcode: "",
    full_address: "",
    type: "",
    created_at: "",
    updated_at: "",
});

const modal = reactive({
    detailAddress: false,
});

const modalDetailAddress = (d) => {
    modal.detailAddress = true;
    selectDataAddress(d);
};

const address = ref([]);
const addressLoading = ref(false);
const addressData = async () => {
    addressLoading.value = true;
    await axios.get(route("addressAll")).then((res) => {
        const data = res.data;
        address.value = data;
        addressLoading.value = false;
    });
};

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(address.value.length / perPage));

const pgntAddress = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchAddress.value.length);
    return searchAddress.value.slice(start, end).map((address, index) => ({
        ...address,
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

const searchIAddress = ref("");
const searchAddress = computed(() => {
    if (!searchIAddress.value) {
        return address.value;
    }
    const lowerCase = searchIAddress.value.toLowerCase();
    if (address.value) {
        return address.value.filter((adr) => {
            return (
                adr.adr_code.toLowerCase().includes(lowerCase) ||
                adr.province.toLowerCase().includes(lowerCase) ||
                adr.user_id.toLowerCase().includes(lowerCase)
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

const selectDataAddress = (d) => {
    detail.adr_code = d.adr_code;
    detail.user_id = d.user_id;
    detail.province = d.province;
    detail.city = d.city;
    detail.district = d.district;
    detail.neighborhood = d.neighborhood;
    detail.zipcode = d.zipcode;
    detail.full_address = d.full_address;
    detail.type = d.type;
    detail.created_at = formatDate(d.created_at);
    detail.updated_at = formatDate(d.updated_at);
};
</script>
<template>
    <Head title="Address" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between item-center mb-4">
                    <h2 class="text-lg font-semibold">Address Data</h2>
                </div>
                <SearchInput
                    v-model="searchIAddress"
                    placeholder="Address Code, Province, User ID"
                ></SearchInput>

                <table class="w-full table-auto">
                    <thead>
                        <tr class="text-left text-gray-500">
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">Address Code</th>
                            <th class="py-2 text-center">User</th>
                            <th class="py-2 text-center">Provinsi</th>
                            <th class="py-2 text-center">City</th>
                            <th class="py-2 text-center">Type</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!addressLoading">
                        <tr
                            v-for="(d, index) in pgntAddress"
                            :key="index"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ d.no }}</td>
                            <td class="py-2 text-center">{{ d.adr_code }}</td>
                            <td class="py-2 text-center">{{ d.user_id }}</td>
                            <td class="py-2 text-center">{{ d.province }}</td>
                            <td class="py-2 text-center">{{ d.city }}</td>
                            <td class="py-2 text-center">{{ d.type }}</td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailAddress(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail Address"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-md text-black"
                        v-if="addressLoading"
                        >Sedang Memuat...</span
                    >
                </div>
                <div class="w-full text-center mt-2">
                    <span
                        class="text-center text-xl text-black"
                        v-if="!addressLoading && address.length < 1"
                        >Tidak Ada Data</span
                    >
                </div>

                <!-- Modal Detail Product -->
                <Modal
                    :show="modal.detailAddress"
                    @close="modal.detailAddress = false"
                    maxWidth="4xl"
                >
                    <template #title>
                        Detail Address #{{ input.adr_code }}</template
                    >
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Province"
                                    id="province"
                                    type="text"
                                    name="province"
                                    v-model="detail.province"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="City"
                                    id="city"
                                    type="text"
                                    name="city"
                                    v-model="detail.city"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="District"
                                    id="district"
                                    type="text"
                                    name="district"
                                    v-model="detail.district"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Neighborhood"
                                    id="neighborhood"
                                    type="text"
                                    name="neighborhood"
                                    v-model="detail.neighborhood"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Zipcode"
                                    id="zipcode"
                                    type="text"
                                    name="zipcode"
                                    v-model="detail.zipcode"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-2">
                                <CustTextInput
                                    label="Full Address"
                                    id="full_address"
                                    type="text"
                                    name="full_address"
                                    v-model="detail.full_address"
                                    :required-indicator="false"
                                />
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    label="Type"
                                    id="type"
                                    type="text"
                                    name="type"
                                    v-model="detail.type"
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
                                        @click="modal.detailAddress = false"
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
