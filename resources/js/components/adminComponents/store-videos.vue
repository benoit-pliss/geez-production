<script setup>
import { ref } from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/solid'
import { createUpload} from "@mux/upchunk";
import {handleSuccess} from "../../services/videosService.js";
import notificationService from "../../services/notificationService.js";

window.createUpload = createUpload;

let uploader = null;
const files = ref(null);
const progress = 0;

const submit = (e) => {
    files.value = e.target.files;

    if(!files.value.length) {
        return;
    }

    Array.from(files.value).forEach(file => {
        uploader = createUpload({
            file: file,
            endpoint: '/api/upload/chunks',
            headers: {
                'Content-Type': 'application/json',
                'Bearer': 'Bearer ' + localStorage.getItem('token')
            },
            method: 'POST',
            chunkSize: 10 * 1024,
        });

        uploader.on('chunkSuccess', (response) => {
            if (!response.detail.response.body) {
                return;
            }

            handleSuccess(file.name, JSON.parse(response.detail.response.body).file)
                .then((res) => {
                    if (res.data.success){
                        notificationService.addToast('Vidéo enregistrée avec succès', 'success');
                    } else {
                        notificationService.addToast('Erreur lors de l\'enregistrement de la vidéo', 'error');
                    }
                })
        });
    });
};

</script>

<template>
    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Ajouter des vidéos</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm leading-6 text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Upload a file</span>
                        <input id="file-upload" name="file-upload" v-on:change.prevent="submit" type="file" class="hidden" multiple/>
                    </label>
                    <p class="pl-1">or drag and drop</p>
                </div>
                <p v-if="files"
                   class="mt-2 text-sm text-gray-500"
                >
                    {{ files.length }} files selected
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
