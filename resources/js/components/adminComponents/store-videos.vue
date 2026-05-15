
<script setup>
import { ref } from 'vue'
import { PhotoIcon } from '@heroicons/vue/24/solid'
import * as tus from 'tus-js-client'
import { initBunnyUpload, refreshBunnyCredentials, completeBunnyUpload } from "../../services/videosService.js";
import notificationService from "../../services/notificationService.js";
import ThumbnailsWrapper from "./thumbnails-wrapper.vue";

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

const getFingerprint = (file) => `bunny-${file.name}-${file.size}-${file.lastModified}`;

const submit = async () => {
    if (!files.value?.length) return;

    uploading.value = true;
    uploadProgress.value = 0;
    fileProgresses.value = {};
    completedCount = 0;
    totalCount = Array.from(files.value).length;

    await Promise.allSettled(Array.from(files.value).map(async (file, index) => {
        fileProgresses.value[index] = 0;

        try {
            const fingerprint = getFingerprint(file);
            const stored = JSON.parse(localStorage.getItem(fingerprint) || 'null');

            let videoId, signature, expires, libraryId;

            if (stored) {
                // Rafraichit les credentials sans créer une nouvelle vidéo
                const { data } = await refreshBunnyCredentials(stored.videoId);
                videoId = stored.videoId;
                signature = data.signature;
                expires = data.expires;
                libraryId = data.libraryId;
            } else {
                const { data } = await initBunnyUpload(file.name);
                videoId = data.videoId;
                signature = data.signature;
                expires = data.expires;
                libraryId = data.libraryId;
                localStorage.setItem(fingerprint, JSON.stringify({ videoId }));
            }

            const upload = new tus.Upload(file, {
                endpoint: 'https://video.bunnycdn.com/tusupload',
                chunkSize: 50 * 1024 * 1024, // 50MB par chunk
                retryDelays: [0, 3000, 5000, 10000, 20000],
                headers: {
                    AuthorizationSignature: signature,
                    AuthorizationExpire: String(expires),
                    VideoId: videoId,
                    LibraryId: String(libraryId),
                },
                metadata: {
                    filename: file.name,
                    filetype: file.type || 'video/mp4',
                },
                onProgress: (bytesUploaded, bytesTotal) => {
                    fileProgresses.value[index] = Math.round((bytesUploaded / bytesTotal) * 100);
                    updateAverageProgress();
                },
                onSuccess: async () => {
                    localStorage.removeItem(fingerprint);
                    try {
                        const res = await completeBunnyUpload(videoId, file.name);
                        if (res.data.success) {
                            notificationService.addToast('Vidéo enregistrée avec succès', 'success');
                            emit('videoUploaded');
                        } else {
                            notificationService.addToast("Erreur lors de l'enregistrement de la vidéo", 'error');
                        }
                    } catch {
                        notificationService.addToast('Erreur serveur', 'error');
                    } finally {
                        fileProgresses.value[index] = 100;
                        updateAverageProgress();
                        completedCount++;
                        if (completedCount >= totalCount) resetForm();
                    }
                },
                onError: () => {
                    notificationService.addToast("Erreur lors de l'upload", 'error');
                    completedCount++;
                    if (completedCount >= totalCount) resetForm();
                },
            });

            const previousUploads = await upload.findPreviousUploads();
            if (previousUploads.length > 0) {
                upload.resumeFromPreviousUpload(previousUploads[0]);
            }

            upload.start();
        } catch {
            notificationService.addToast("Erreur lors de l'initialisation de l'upload", 'error');
            completedCount++;
            if (completedCount >= totalCount) resetForm();
        }
    }));
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
                        <input id="file-upload" name="file-upload" ref="fileInputRef" v-on:change.prevent="onSubmit" type="file" class="hidden" multiple />
                    </label>
                    <p class="pl-1">ou glisser-déposer</p>
                </div>
                <p v-if="files" class="mt-2 text-sm text-gray-500">
                    {{ files.length }} fichier(s) sélectionné(s)
                </p>

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
