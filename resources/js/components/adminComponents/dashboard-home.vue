<script setup>
import { ref } from 'vue';
import axiosClient from '../../axios/index.js';
import notificationService from '../../services/notificationService.js';

const syncing = ref(null);

async function sync(type) {
    syncing.value = type;
    try {
        const { data } = await axiosClient.post(`/sync/${type}`);
        notificationService.addToast(
            `Sync terminée — ${data.created} ajouté(s), ${data.skipped} déjà présent(s)`,
            'success'
        );
    } catch (e) {
        notificationService.addToast('Erreur lors de la synchronisation', 'error');
        console.error(e.response?.data ?? e);
    } finally {
        syncing.value = null;
    }
}
</script>

<template>
    <div class="flex flex-col gap-6 p-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-800 mb-1">Synchronisation Cloudinary</h2>
            <p class="text-sm text-gray-500 mb-4">
                Importe dans la base de données les fichiers déjà uploadés sur Cloudinary.
            </p>
            <div class="flex gap-4">
                <button
                    @click="sync('images')"
                    :disabled="syncing !== null"
                    class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
                >
                    <span v-if="syncing === 'images'">Sync en cours...</span>
                    <span v-else>Sync Photos</span>
                </button>
                <button
                    @click="sync('videos')"
                    :disabled="syncing !== null"
                    class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
                >
                    <span v-if="syncing === 'videos'">Sync en cours...</span>
                    <span v-else>Sync Vidéos</span>
                </button>
            </div>
        </div>
    </div>
</template>
