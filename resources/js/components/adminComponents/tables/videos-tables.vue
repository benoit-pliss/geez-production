<script setup>

import {ref, watch} from "vue";
import {updateVideo} from "../../../services/videosService.js";
import ComboboxTags from "../../dialog/create-tags/combobox-tags.vue";
import notificationService from "../../../services/notificationService.js";

import Badge from "@/components/Badge.vue";

let editingId = ref(null);
const isSaving = ref(false);
const originalVideo = ref(null);

const props = defineProps({
    photos: Array
})

const emits = defineEmits(['searchName']);

const name = ref('');

watch(name, (newValue) => {
    emits('searchName', newValue);
})

const addtags = (tag) => {
    const photo = props.photos.find(p => p.id === editingId.value);
    if (!photo.tags.some(existingTag => existingTag.id === tag.id)) {
        photo.tags.push(tag);
    } else {
        notificationService.addToast(
            "Ce tag est déjà associé à cette photo",
            "error"
        )
    }
}

const removeTag = (tagId) => {
    const video = props.photos.find(p => p.id === editingId.value);
    if (video) {
        video.tags = video.tags.filter(t => t.id !== tagId);
    }
}

function startEdit(video) {
    originalVideo.value = JSON.parse(JSON.stringify(video));
    editingId.value = video.id;
}

function cancelEdit(video) {
    Object.assign(video, originalVideo.value);
    editingId.value = null;
    originalVideo.value = null;
}

async function saveChanges(video) {
    isSaving.value = true;
    try {
        await updateVideo(video);
        notificationService.addToast('Modifications enregistrées', 'success');
        editingId.value = null;
        originalVideo.value = null;
    } catch {
        notificationService.addToast('Erreur lors de la sauvegarde', 'error');
    } finally {
        isSaving.value = false;
    }
}

</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Miniature</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Nom de la vidéo</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tags associés</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Visible</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-right">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <!--                        <tr>-->
                        <!--                            <td></td> &lt;!&ndash; Empty cell for "Miniature" column &ndash;&gt;-->
                        <!--                            <td class="py-4 pl-4 pr-3 sm:pl-0"> &lt;!&ndash; Cell for "Name" column &ndash;&gt;-->
                        <!--                                <input type="text" v-model="name" placeholder="Search by name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>-->
                        <!--                            </td>-->
                        <!--                            &lt;!&ndash; Add more empty cells for other columns if needed &ndash;&gt;-->
                        <!--                        </tr>-->
                        <tr v-for="photo in props.photos" :key="photo.id">
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <img :src="photo.poster_url" alt="Photo miniature" width="50" height="50">
                            </td>

                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                <span v-if="editingId !== photo.id">{{ photo.name }}</span>

                                <div v-else>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" v-model="photo.name"  class="block w-full rounded-md border-0 py-1.5 px-2 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 max-w-xs overflow-auto">
                                <span v-if="editingId !== photo.id">{{ photo.description }}</span>

                                <div v-else>
                                    <div class="mt-2">
                                        <input type="text" name="description" id="description" v-model="photo.description"  class="block w-full rounded-md border-0 py-1.5 px-2 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 max-w-xs">
                                <div v-if="editingId !== photo.id" class="flex flex-wrap w-full gap-4">
                                    <Badge v-for="tag in photo.tags" :key="tag.id" :is-dashboard="1" :label="tag.name" :color="tag.color ? tag.color : null" />
                                </div>

                                <div v-else>

                                    <div class="flex flex-wrap w-full gap-4">
                                        <Badge v-for="tag in photo.tags" :key="tag.id" :label="tag.name" :color="tag.color ? tag.color : null" :id="tag.id" :onClick="removeTag" type="remove" :isDashboard="0"/>
                                    </div>


                                    <ComboboxTags
                                        :is-assigned="false"
                                        class="combobox"
                                        @update:selectedTag="addtags"
                                    />

                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ photo.type }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a v-if="editingId !== photo.id" href="#" @click.prevent="startEdit(photo)" class="text-indigo-600 hover:text-indigo-900">
                                    Modifier<span class="sr-only">, {{ photo.name }}</span>
                                </a>
                                <div v-else class="flex justify-end gap-3">
                                    <button @click="cancelEdit(photo)" class="text-gray-500 hover:text-gray-700">Annuler</button>
                                    <button @click="saveChanges(photo)" :disabled="isSaving" class="text-green-600 hover:text-green-800 disabled:opacity-50">
                                        {{ isSaving ? 'Sauvegarde...' : 'Sauvegarder' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

.combobox {
    z-index: 1000;
}

</style>
