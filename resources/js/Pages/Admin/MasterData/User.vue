<script setup>
import { computed, onMounted, reactive, readonly, ref } from "vue";
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Modal from "@/Components/DialogModal.vue";
import CustTextInput from "@/Components/CustTextInput.vue";
import axios from "axios";
import { Notyf } from "notyf";
import "notyf/notyf.min.css";

onMounted(() => {
    userData();
});

defineProps({
    errors: Object,
});

//notifikasi
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
    user_id: "",
    username: "",
    fullname: "",
    email: "",
    phone: "",
    status: "",
    verifikasi: "",
    role: "",
});

const modal = reactive({
    detailUser: false,
});

const modalDetailUser = (d) => {
    selectDataUser(d);
    modal.detailUser = true;
};

const userAll = () => {

}
 
//fetch user data
const user = ref([]);
const userLoading = ref(false);
const userData = async () => {
    userLoading.value = true;
    await axios.get(route("userAll")).then((res) => {
        const data = res.data;
        user.value = data;
        userLoading.value = false;
    });
};

//pagination
const crntPage = ref(1);
const perPage = 5;

const totalPages = computed(() => Math.ceil(user.value.length / perPage));

const pgntUser = computed(() => {
    const start = (crntPage.value - 1) * perPage;
    const end = Math.min(start + perPage, searchUser.value.length);
    return searchUser.value.slice(start, end).map((user, index) => ({
        ...user,
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

const searchIUser = ref("");
const searchUser = computed(() => {
    if (!searchIUser.value) {
        return user.value;
    }
    const lowerCase = searchIUser.value.toLowerCase();
    if (user.value) {
        return user.value.filter((usr) => {
            return usr.user_id.toLowerCase().includes(lowerCase);
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

//select data user
const selectDataUser = (d) => {
    input.user_id = d.user_id;
    input.username = d.username;
    input.fullname = d.fullname;
    input.email = d.email;
    input.phone = d.phone;
    if (d.status == 1) {
        input.status = "Aktif";
    } else {
        input.status = "Tidak Aktif";
    }

    input.verifikasi = formatDate(d.email_verified_at);
    input.role = d.role;
};

//update status to active
const updateAktif = async (d) => {
    try {
        // Show loading state
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0, // Keep it open until dismissed
        });

        // Perform the API request
        await axios.post(route("updateAktif"), { user_id: d.user_id });

        // Dismiss loading state
        notyf.dismiss(loadingNotification);

        // Show success message
        notyf.open({
            type: "success",
            message: "Berhasil memperbarui status user",
        });

        // Refresh user data
        userData();
    } catch (error) {
        console.log(error);
        // Dismiss loading state
        notyf.dismiss(loadingNotification);

        // Show error message
        notyf.open({
            type: "error",
            message: "Terjadi Kesalahan",
        });
    }
};

//update status to inactive
const updateNonAktif = async (d) => {
    try {
        // Show loading state
        const loadingNotification = notyf.open({
            type: "info",
            message: "Mohon Tunggu",
            duration: 0, // Keep it open until dismissed
        });

        // Perform the API request
        await axios.post(route("updateNonAktif"), {
            user_id: d.user_id,
        });

        // Dismiss loading state
        notyf.dismiss(loadingNotification);

        // Show success message
        notyf.open({
            type: "success",
            message: "Berhasil memperbarui status user",
        });

        // Refresh user data
        userData();
    } catch (error) {
        console.log(error);

        // Dismiss loading state
        notyf.dismiss(loadingNotification);

        // Show error message
        notyf.open({
            type: "error",
            message: "Terjadi Kesalahan",
        });
    }
};
</script>
<template>
    <Head title="Dashboard" />
    <AdminLayout>
        <template #content>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Users Data</h2>
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
                            <th class="py-2 text-center">#</th>
                            <th class="py-2 text-center">User ID</th>
                            <th class="py-2 text-center">User Name</th>
                            <th class="py-2 text-center">Full Name</th>
                            <th class="py-2 text-center">Email</th>
                            <th class="py-2 text-center">Phone</th>
                            <th class="py-2 text-center">Verifikasi Email</th>
                            <th class="py-2 text-center">Status</th>
                            <th class="py-2 text-center">Detail</th>
                        </tr>
                    </thead>
                    <tbody v-if="!userLoading">
                        <tr
                            v-for="(d, index) in pgntUser"
                            :key="d.user_id"
                            class="border-b hover:bg-gray-100"
                        >
                            <td class="py-2 text-center">{{ index + 1 }}</td>
                            <td class="py-2 text-center">{{ d.user_id }}</td>
                            <td class="py-2 text-center">{{ d.username }}</td>
                            <td class="py-2 text-center">{{ d.fullname }}</td>
                            <td class="py-2 text-center">{{ d.email }}</td>
                            <td class="py-2 text-center">{{ d.phone }}</td>
                            <td class="py-2 text-center">
                                {{ formatDate(d.email_verified_at) }}
                            </td>
                            <td class="py-2 text-center" v-if="d.status == 1">
                                <a @click="updateNonAktif(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/switch-off.png"
                                        title="Tekan tombol ini jika ingin merubah status"
                                /></a>
                            </td>
                            <td class="py-2 text-center" v-if="d.status == 0">
                                <a @click="updateAktif(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/switch-on.png"
                                        title="Tekan tombol ini jika ingin merubah status"
                                /></a>
                            </td>
                            <td class="py-2 text-center">
                                <a @click="modalDetailUser(d)"
                                    ><img
                                        class="m-auto cursor-pointer"
                                        src="/storage/icon/info.png"
                                        title="Detail User"
                                /></a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="flex justify-between items-center mt-4">
                    <span
                        >Showing {{ pgntUser.length }} of
                        {{ user.length }} Results</span
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

                <!-- Modal Detail User -->
                <Modal
                    :show="modal.detailUser"
                    maxWidth="2xl"
                    classHeader="bg-sky-700 text-white"
                >
                    <template #title> Detail User </template>
                    <template #content>
                        <div class="mt-6 grid grid-cols-2 gap-4">
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    User ID :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="user_id_dtl"
                                    type="text"
                                    name="user_id_dtl"
                                    v-model="input.user_id"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    User Name :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="user_name_dtl"
                                    type="text"
                                    name="user_name_dtl"
                                    v-model="input.username"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Full Name :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="password_dtl"
                                    type="text"
                                    name="password_dtl"
                                    v-model="input.fullname"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Email :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="level_user_dtl"
                                    type="text"
                                    name="level_user_dtl"
                                    v-model="input.email"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Phone :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="level_user_dtl"
                                    type="text"
                                    name="level_user_dtl"
                                    v-model="input.phone"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Verifikasi :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="level_user_dtl"
                                    type="text"
                                    name="level_user_dtl"
                                    v-model="input.verifikasi"
                                    :readonly="true"
                                />
                            </div>
                            <div class="sm:col-span-1 pt-5">
                                <h1
                                    class="tracking-wide block mb-2 text-xs font-bold text-gray-900 uppercase"
                                >
                                    Status :
                                </h1>
                            </div>
                            <div class="sm:col-span-1">
                                <CustTextInput
                                    :requiredIndicator="false"
                                    id="level_user_dtl"
                                    type="text"
                                    name="level_user_dtl"
                                    v-model="input.status"
                                    :readonly="true"
                                />
                            </div>
                        </div>
                        <div class="flex justify-end items">
                            <div class="ml-4">
                                <div class="text-black">
                                    <button
                                        @click="modal.detailUser = false"
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
