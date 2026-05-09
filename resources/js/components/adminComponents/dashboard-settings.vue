<script setup>
import { ref, onMounted } from 'vue';
import { getSettings, updateSettings } from '../../services/settingsService.js';
import notificationService from '../../services/notificationService.js';

const defaultSound = ref(false);
const saving = ref(false);

onMounted(async () => {
    try {
        const { data } = await getSettings();
        defaultSound.value = data.settings.video_default_sound === '1';
    } catch {
        notificationService.addToast('Erreur lors du chargement des paramètres', 'error');
    }
});

const save = async () => {
    saving.value = true;
    try {
        await updateSettings({ video_default_sound: defaultSound.value });
        notificationService.addToast('Paramètres sauvegardés', 'success');
    } catch {
        notificationService.addToast('Erreur lors de la sauvegarde', 'error');
    } finally {
        saving.value = false;
    }
};
</script>

<template>
    <div>
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Paramètres vidéos</h2>

        <div class="flex items-center justify-between py-4 border-b border-gray-200">
            <div>
                <p class="text-sm font-medium text-gray-900">Son actif par défaut</p>
                <p class="text-sm text-gray-500 mt-0.5">La vidéo de présentation démarrera avec le son activé</p>
            </div>
            <button
                @click="defaultSound = !defaultSound; save()"
                :class="[defaultSound ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none']"
                :disabled="saving"
            >
                <span :class="[defaultSound ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
            </button>
        </div>

        <p class="mt-6 text-sm text-gray-500 bg-gray-50 rounded-lg p-3">
            Pour définir la <strong>vidéo de présentation</strong>, rendez-vous dans l'onglet
            <strong>Vidéos</strong> et cliquez sur l'étoile ★ à côté de la vidéo souhaitée.
        </p>
    </div>
</template>
