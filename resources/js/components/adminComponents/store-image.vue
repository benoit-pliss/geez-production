<script setup>
import {ref} from "vue";
import axiosClient from "../../axios/index.js";

const file = ref(null);
const images = ref([]);

const onFileChange = (e) => {
    file.value = e.target.files[0];
};

async function upload() {
    if (!file.value) {
        return;
    }

    const formData = new FormData();
    formData.append('image', file.value);

    try {
        await axiosClient.post('/upload/photos', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        console.log(response.data);
    } catch (error) {
        console.log(error.response);
    }
}
</script>

<template>

<!--    file input-->

    <div class="max-w-2xl mx-auto" data-theme="light">

        <div class="flex items-center justify-center w-full" data-theme="light">
            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer  dark:hover:bg-bray-800  hover:bg-gray-100 ">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>

                </div>
                <input id="dropzone-file" type="file" class="hidden" @change="onFileChange"/>
            </label>
        </div>
        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded" @click="upload">Valider</button>
    </div>

</template>

<style scoped>

</style>
