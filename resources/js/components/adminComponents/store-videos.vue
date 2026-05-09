
<script setup>
import {ref} from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/solid'
import { createUpload} from "@mux/upchunk";
import {handleSuccess} from "../../services/videosService.js";
import notificationService from "../../services/notificationService.js";
import ThumbnailsWrapper from "./thumbnails-wrapper.vue";
import {uploadThumbnails} from "../../services/Photo-service.js";

window.createUpload = createUpload;

const emit = defineEmits(['videoUploaded']);
const thumbnails = ref([])
const files = ref(null);
const uploading = ref(false);
const uploadProgress = ref(0);
const fileInputRef = ref(null);
const fileProgresses = ref({});
let completedCount = 0;
let totalCount = 0;

const onSubmit = (e) => {
    files.value = e.target.files;
};

const resetForm = () => {
    files.value = null;
    uploading.value = false;
    uploadProgress.value = 0;
    fileProgresses.value = {};
    completedCount = 0;
    totalCount = 0;
    if (fileInputRef.value) fileInputRef.value.value = '';
};

const updateAverageProgress = () => {
    const values = Object.values(fileProgresses.value);
    if (!values.length) return;
    uploadProgress.value = Math.round(values.reduce((a, b) => a + b, 0) / values.length);
};

const submit = (e) => {
    if (!files.value?.length) return;

    uploading.value = true;
    uploadProgress.value = 0;
    fileProgresses.value = {};
    completedCount = 0;
    totalCount = Array.from(files.value).length;

    Array.from(files.value).forEach((file, index) => {
        fileProgresses.value[index] = 0;

        const uploadId = crypto.randomUUID();
        const uploader = createUpload({
            file: file,
            endpoint: '/api/upload/chunks',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'X-File-Name': encodeURIComponent(file.name),
                'X-Upload-ID': uploadId,
            },
            method: 'POST',
            chunkSize: 1024, // 1MB per chunk (chunkSize unit is kB)
        });

        uploader.on('progress', (e) => {
            fileProgresses.value[index] = Math.round(e.detail);
            updateAverageProgress();
        });

        uploader.on('chunkSuccess', (response) => {
            if (!response.detail.response.body) return;
            const body = JSON.parse(response.detail.response.body);
            if (!body.file) return;

            handleSuccess(file.name, body.file)
                .then((res) => {
                    if (res.data.success) {
                        notificationService.addToast('Vidéo enregistrée avec succès', 'success');
                        emit('videoUploaded');
                        generateAndUploadThumbnail(file, res.data.entity?.name ?? file.name);
                    } else {
                        notificationService.addToast('Erreur lors de l\'enregistrement de la vidéo', 'error');
                    }
                })
                .catch(() => {
                    notificationService.addToast('Erreur serveur', 'error');
                })
                .finally(() => {
                    fileProgresses.value[index] = 100;
                    updateAverageProgress();
                    completedCount++;
                    if (completedCount >= totalCount) resetForm();
                });
        });

        uploader.on('error', () => {
            notificationService.addToast('Erreur lors de l\'upload', 'error');
            completedCount++;
            if (completedCount >= totalCount) resetForm();
        });
    });
};

const generateAndUploadThumbnail = (file, videoName) => {
    const nameWithoutExt = videoName.includes('.') ? videoName.split('.').slice(0, -1).join('.') : videoName;
    const objectUrl = URL.createObjectURL(file);
    const video = document.createElement('video');
    video.preload = 'metadata';
    video.muted = true;
    video.src = objectUrl;

    video.addEventListener('loadedmetadata', () => {
        video.currentTime = video.duration > 1 ? 1 : (video.duration > 0 ? video.duration / 2 : 0);
    });

    video.addEventListener('seeked', () => {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        URL.revokeObjectURL(objectUrl);

        canvas.toBlob(async (blob) => {
            if (!blob) {
                notificationService.addToast('Erreur lors de la génération de la vignette', 'error');
                return;
            }
            const thumbFile = new File([blob], 'thumbnail-0.jpg', { type: 'image/jpeg' });
            const formData = new FormData();
            formData.append('videoName', nameWithoutExt);
            formData.append('file', thumbFile);
            try {
                const response = await uploadThumbnails(formData);
                if (response.data.success) {
                    notificationService.addToast(response.data.message, 'success');
                }
            } catch {
                notificationService.addToast('Erreur lors de la génération de la vignette', 'error');
            }
        }, 'image/jpeg', 0.8);
    });

    video.addEventListener('error', () => {
        URL.revokeObjectURL(objectUrl);
        notificationService.addToast('Format vidéo non supporté pour la vignette', 'error');
    });
};
</script>

<template>
    <div class="col-span-full">
        <label class="block text-sm font-medium leading-6 text-gray-900">Ajouter des vidéos</label>
        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
            <div class="text-center w-full max-w-sm">
                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                        <span>Choisir un fichier</span>
                        <input id="file-upload" name="file-upload" ref="fileInputRef" v-on:change.prevent="onSubmit" type="file" class="hidden" multiple/>
                    </label>
                    <p class="pl-1">ou glisser-déposer</p>
                </div>
                <p v-if="files" class="mt-2 text-sm text-gray-500">
                    {{ files.length }} fichier(s) sélectionné(s)
                </p>

                <!-- Barre de progression -->
                <div v-if="uploading" class="mt-4 w-full">
                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                        <span>Upload en cours...</span>
                        <span>{{ uploadProgress }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-indigo-600 h-2 rounded-full transition-all duration-300" :style="{ width: uploadProgress + '%' }"></div>
                    </div>
                </div>

                <div class="mt-4 flex leading-6 text-gray-600 justify-center">
                    <button
                        class="bg-indigo-600 rounded-lg text-white font-semibold text-xs px-4 py-3 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="uploading || !files?.length"
                        v-on:click="submit"
                    >
                        {{ uploading ? 'Upload en cours...' : 'Ajouter' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <ThumbnailsWrapper :thumbnails="thumbnails"/>
</template>

<style scoped>
</style>
