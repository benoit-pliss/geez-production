<script setup>
import {ref} from "vue";
import {uploadPhoto} from "../../services/Photo-service.js";
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
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
        await uploadPhoto(formData)
            .then((res) => {
            images.value.push(res.data);
            file.value = null;
        })
            .catch((err) => {
                console.log(err);
            })

    } catch (error) {
        console.log(error.response);
    }
}
</script>

<template>

<!--    file input-->


    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Ajouter des photos</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Upload a file</span>
                        <input id="file-upload" name="file-upload" type="file" class="hidden" @change="onFileChange" />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p v-if="file"
                     class="mt-2 text-sm text-gray-500"
                >
                    {{ file.name }}
                </p>
            </div>
        </div>
        <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded" @click="upload">Valider</button>
    </div>

</template>

<style scoped>

</style>
