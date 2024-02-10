<script setup>
import {ref} from "vue";
import {uploadPhoto} from "../../services/Photo-service.js";
import {Photos} from "../../Models/Photos.js";
import { PhotoIcon } from '@heroicons/vue/24/solid'
import notificationService from "../../services/notificationService.js";


const files = ref([]);
const images = ref([]);

const onFileChange = (e) => {
    const newFiles = Array.from(e.target.files || e.dataTransfer.files);
    newFiles.forEach((file) => {
        const photo = new Photos(file.name, '', file);
        files.value.push(photo);
    });

    console.log(files.value);
};

async function upload() {
    if (!files.value.length) {
        return;
    }

    for (const file of files.value) {
        const formData = new FormData();
        formData.append('image', file);

        try {
            console.log(formData);
            await uploadPhoto(formData)
                .then((res) => {
                    console.log(res);
                    if (res.data.success === false) {
                        notificationService.addToast(
                            res.data.message,
                            'error'
                        )
                    } else {
                        notificationService.addToast(
                            res.data.message,
                            'success'
                        )
                    }

                })
                .catch((err) => {
                    console.log(err);
                    notificationService.addToast(
                        err.response.data.message,
                        'error'
                    )
                })

        } catch (error) {
            console.log(error.response);
        }
    }

    // Reset files after upload
    files.value = [];
}


</script>

<template>

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6" data-theme="light" v-if="files.length === 1" >
        <div class="sm:col-span-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom du Fichier</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input v-model="files[0].name" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="name" />
                </div>
            </div>
        </div>

        <div class="col-span-full">
            <label for="desc" class="block text-sm font-medium leading-6 text-gray-900">Desciption</label>
            <div class="mt-2">
                <textarea id="desc" name="desc" rows="3" v-model="files[0].description" placeholder="Description du Fichier" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>
    </div>

<!--    file input-->

    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Ajouter des photos</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Upload a file</span>
                        <input id="file-upload" name="file-upload" type="file" class="hidden" @change="onFileChange" multiple />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p v-if="files.length" v-for="file in files"
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
