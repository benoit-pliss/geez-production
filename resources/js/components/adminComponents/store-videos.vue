<script setup>
import { ref } from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/solid'
import { createUpload} from "@mux/upchunk";
import {handleSuccess} from "../../services/videosService.js";
import notificationService from "../../services/notificationService.js";

window.createUpload = createUpload;

let uploader = null;
const file = ref(null);
const progress = 0;

const submit = (e) => {
    file.value = e.target.files[0];

    if(!file.value) {
        return;
    }

    uploader = createUpload({
        file: file.value,
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

        handleSuccess(file.value.name, JSON.parse(response.detail.response.body).file)
            .then((res) => {
                if (res.data.success){
                    notificationService.addToast('Vidéo enregistrée avec succès', 'success');
                } else {
                    notificationService.addToast('Erreur lors de l\'enregistrement de la vidéo', 'error');
                }
            })
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
                        <input id="file-upload" name="file-upload" v-on:change.prevent="submit" type="file" class="hidden"/>
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
<!--        <div class="mt-6 flex justify-center items-center">-->
<!--            <button v-if="!isUploading" type="button" @click="upload"-->
<!--                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus-visible:outline focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">-->
<!--                Valider-->
<!--            </button>-->

<!--            <progress v-if="isUploading" class="progress w-56"></progress>-->
<!--        </div>-->
    </div>
</template>

<style scoped>

</style>
