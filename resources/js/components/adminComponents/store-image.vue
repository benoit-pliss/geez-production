<script setup>
import {ref} from "vue";
import {uploadPhoto} from "../../services/Photo-service.js";
import { PhotoIcon } from '@heroicons/vue/24/solid'
import Notifications from "./notifications.vue";

const files = ref([]);


const images = ref([]);
const notifications = ref({
    show: false,
    message: '',
    type: ''
});

const onFileChange = (e) => {
    files.value = Array.from(e.target.files || e.dataTransfer.files);
};

async function upload() {
    if (!files.value.length) {
        return;
    }

    for (const file of files.value) {
        const formData = new FormData();
        formData.append('image', file);

        try {
            await uploadPhoto(formData)
                .then((res) => {
                    console.log(res);
                    if (res.data.success === false) {
                        notifications.value = {
                            show: true,
                            message: res.data.message,
                            type: 'error'
                        }
                    } else {
                        images.value.push(res.data);
                        notifications.value = {
                            show: true,
                            message: 'Photo bien enregistrée',
                            type: 'success'
                        }
                    }

                })
                .catch((err) => {
                    console.log(err);
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

<!--    file input-->
    <Notifications v-if="notifications.show" :message="notifications.message" :type="notifications.type" :duration="2000" @close="notifications.show = false" />


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
