<template>
    <div class="dropzone-component">
        <label class="block text-xs uppercase font-medium text-gray-700"
            >{{ label }}
            <span v-if="requiredIndicator" class="text-sm text-red-600"
                >*</span
            ></label
        >
        <div
            @dragover.prevent
            @drop.prevent="handleFileDrop"
            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-lg hover:border-yellow-500"
        >
            <div class="space-y-1 text-center">
                <!-- Icon -->
                <img src="/storage/icon/upload.png" class="m-auto" />

                <!-- File Input -->
                <div class="flex text-sm text-gray-600">
                    <label
                        for="file-upload"
                        class="relative cursor-pointer rounded-md font-medium text-yellow-600 hover:text-yellow-500"
                    >
                        <span
                            >Drag and drop your files or browse your files</span
                        >
                        <input
                            id="file-upload"
                            type="file"
                            class="sr-only"
                            :required="requiredIndicator"
                            @change="handleFileChange"
                            :multiple="multiple"
                        />
                    </label>
                </div>

                <!-- Display Uploaded Files -->
                <div v-if="fileList.length > 0" class="mt-2 text-gray-500">
                    <p v-for="(file, index) in fileList" :key="index">
                        {{ file.name }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";

// Accept v-model as a prop
const props = defineProps({
    label: {
        type: String,
    },
    requiredIndicator: {
        type: Boolean,
        default: false,
    },
    multiple: {
        type: Boolean,
        default: false,
    },
    modelValue: {
        type: Array,
        default: () => [],
    },
});

// Emit event to update v-model in the parent
const emit = defineEmits(["update:modelValue"]);

// File list is bound to the prop value
const fileList = ref([...props.modelValue]);

// Handle file upload via input
const handleFileChange = (event) => {
    const files = event.target.files;
    addFilesToList(files);
};

// Handle file upload via drag-and-drop
const handleFileDrop = (event) => {
    const files = event.dataTransfer.files;
    addFilesToList(files);
};

// Add selected files to the list and emit updated modelValue
const addFilesToList = (files) => {
    const newFiles = Array.from(files);
    fileList.value = [...fileList.value, ...newFiles];
    emit("update:modelValue", fileList.value);
};

// Watch for changes in modelValue prop and update fileList accordingly
watch(
    () => props.modelValue,
    (newValue) => {
        fileList.value = newValue;
    }
);
</script>

<style scoped>
/* Custom styles for the dropzone component */
</style>
