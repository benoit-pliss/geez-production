<script setup>
import {ref, watch} from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/solid'
import { createUpload} from "@mux/upchunk";
import {handleSuccess} from "../../services/videosService.js";
import notificationService from "../../services/notificationService.js";
import {generateVideoThumbnails} from "@rajesh896/video-thumbnails-generator";
import ThumbnailsWrapper from "./thumbnails-wrapper.vue";
import {uploadPhoto, uploadThumbnails} from "../../services/Photo-service.js";

window.createUpload = createUpload;

let uploader = null;
const thumbnails = ref([])
const files = ref(null);
const progress = 0;

const onSubmit = (e) => {
    files.value = e.target.files;
    console.log('ajout dune video', files.value);
};

const submit = (e) => {

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

const generateThumbnail = () => {

    if(!files.value.length) {
        return;
    }

    Array.from(files.value).forEach(file => {
        generateVideoThumbnails(file, 1)
            .then((thumbArray) => {
                thumbnails.value.push(thumbArray[0]);
                uploadThumbnailsmethod();
            })
            .catch((err) => {
                console.log('err', err);
            });
    });
};

async function uploadThumbnailsmethod() {
    console.log('thumbnails', thumbnails.value);
    if (!thumbnails.value.length) {
        return;
    }
    try {
        for (let i = 0; i < thumbnails.value.length; i++) {
            const formData = new FormData();

            // Convertir la vignette en Blob
            const response = await fetch(thumbnails.value[i]);
            const blob = await response.blob();

            // Créer un fichier à partir du Blob
            const file = new File([blob], `thumbnail-${i}.jpg`, { type: 'image/jpeg' });
            const videoName = files.value[0].name.split('.').slice(0, -1).join('.');

            formData.append('videoName', videoName);
            formData.append('file', file);

            await uploadThumbnails(formData)
                .then(response => {
                    if (response.data.success) {
                        notificationService.addToast(response.data.message, 'success');
                    } else {
                        notificationService.addToast(response.data.message, 'error');
                    }
                })
                .catch(error => {
                    notificationService.addToast('Erreur lors de l\'enregistrement du fichier', 'error');
                    console.log(error);
                });
        }
    } catch (error) {
        notificationService.addToast('ERROROROROROR', 'error');
    }

    // Reset thumbnails after upload
    thumbnails.value = [];
}

</script>

<template>
    <div class="col-span-full">
        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Ajouter des vidéos</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Choisir un fichier</span>
                        <input id="file-upload" name="file-upload" v-on:change.prevent="onSubmit" type="file" class="hidden" multiple/>
                    </label>
                    <p class="pl-1">ou glisser-déposer</p>
                </div>
                <p v-if="files"
                   class="mt-2 text-sm text-gray-500"
                >
                    {{ files.length }} fichier(s) sélectionné(s)
                </p>
                <!-- Ajout des boutons -->
                <div class="mt-4 flex leading-6 text-gray-600 justify-center space-x-4">
                    <button class="bg-secondary rounded-lg text-white font-semibold text-xs px-4 py-3" v-on:click="submit">Ajouter</button>
                    <button class="bg-primary rounded-lg text-white font-semibold text-xs px-4 py-3" v-on:click="generateThumbnail">Générer les vignettes</button>
                </div>
            </div>
        </div>
    </div>

    <ThumbnailsWrapper :thumbnails="thumbnails"/>
</template>

<style scoped>

</style>
