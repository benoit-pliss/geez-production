<script setup>
import {ref} from "vue";
import {uploadPhoto} from "../../services/Photo-service.js";
import {Photos} from "../../Models/Photos.js";
import { PhotoIcon } from '@heroicons/vue/24/solid'
import notificationService from "../../services/notificationService.js";
import ListeTags from "./tags/liste-tags.vue";

const emits = defineEmits([
    'update:photos'
]);

const files = ref([]);
const file = ref(null);
const FileTypeAccepted = [
    'image/jpg',
    'image/jpeg',
    'image/png'
];
const TagsSelected = ref([]);

const onFileChange = (e) => {
    const filesTmp = e.target.files;

    for (let i = 0; i < filesTmp.length; i++) {
        const file = filesTmp[i];

        if (FileTypeAccepted.includes(file.type)) {
            files.value.push(file);
        } else {
            notificationService.addToast('Le fichier doit être une image', 'error');
        }
    }
};

async function upload() {
    if (!files.value.length) {
        return;
    }
    try {

        for (let i = 0; i < files.value.length; i++) {
            const formData = new FormData();

            formData.append('file', files.value[i]);

            if (files.value.length === 1) {
                formData.append('name', files.value[i].name);
                formData.append('description', files.value[i].description);

            } else {
                formData.append('name', '');
                formData.append('description', '');
            }

            if (TagsSelected.value.length > 0) {
                formData.append('tags', JSON.stringify(TagsSelected.value));
            }

            await uploadPhoto(formData)
                .then(response => {
                    if (response.data.success) {
                        notificationService.addToast(response.data.message, 'success');
                    } else {
                        notificationService.addToast(response.data.message, 'error');
                    }
                })
                .catch(error => {
                    notificationService.addToast('Erreur lors de l\'enregistrement du fichier', 'error');
                });

        }

        emits('update:photos');

    } catch (error) {
        notificationService.addToast('ERROROROROROR', 'error');
    }

    // Reset files after upload
    files.value = [];
    TagsSelected.value = [];
}

const addTag = (tag) => {
    TagsSelected.value.push(tag);
    console.log(TagsSelected.value);
}

const removeTag = (tag) => {
    TagsSelected.value = TagsSelected.value.filter(t => t !== tag);
    console.log(TagsSelected.value);
}


</script>

<template>

    <div class="mt-10 flex flex-col gap-4 sm:grid-cols-6" data-theme="light">

        <div class="sm:col-span-4" v-if="files.length === 1">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom du Fichier</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input v-model="files[0].name" type="text" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="name" />
                </div>
            </div>
        </div>

        <div class="col-span-full" v-if="files.length === 1">
            <label for="desc" class="block text-sm font-medium leading-6 text-gray-900">Desciption</label>
            <div class="mt-2">
                <textarea id="desc" name="desc" rows="3" v-model="files[0].description" placeholder="Description du Fichier" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>

        <liste-tags  v-if="files.length >= 1" @add-tag="addTag" @remove-tag="removeTag"/>


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
        <div class="mt-6 flex justify-center items-center">
            <button type="button" @click="upload"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus-visible:outline focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">
                Valider
            </button>
        </div>
    </div>

</template>

<style scoped>

</style>
