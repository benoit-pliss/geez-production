<script setup>

import {ref} from "vue";
import {updatePhoto} from "../../../services/Photo-service.js";
import ComboboxTags from "../../dialog/create-tags/combobox-tags.vue";
import notificationService from "../../../services/notificationService.js";

let editingId = ref(null);

const props = defineProps({
    photos: Array
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

const removeTag = (tag) => {
    if (props.photos.find(p => p.id === editingId.value).tags.includes(tag)) {
        props.photos.find(p => p.id === editingId.value).tags = props.photos.find(p => p.id === editingId.value).tags.filter(t => t.id !== tag.id);
    }
}

async function saveChanges(photo) {

    await updatePhoto(photo)
        .then(response => {
            console.log(response);
        })
    editingId.value = null;
}

</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Miniature</th>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Descirption</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Tags</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Visible</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr v-for="photo in props.photos" :key="photo.id">
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <img :src="photo.url" alt="Photo miniature" width="50" height="50">
                            </td>

                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">
                                <span v-if="editingId !== photo.id">{{ photo.name }}</span>

                                <div v-else>
                                    <div class="mt-2">
                                        <input type="text" name="name" id="name" v-model="photo.name"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 max-w-xs overflow-auto">
                                <span v-if="editingId !== photo.id">{{ photo.description }}</span>

                                <div v-else>
                                    <div class="mt-2">
                                        <input type="text" name="description" id="description" v-model="photo.description"  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"/>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 max-w-xs">
                                <div v-if="editingId !== photo.id" class="flex flex-wrap w-full gap-4">
                                    <span v-for="tag in photo.tags" :key="tag.id"
                                          class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10 cursor-pointer">
                                        {{ tag.name }}
                                    </span>
                                </div>

                                <div v-else>

                                    <div class="flex flex-wrap w-full gap-4">
                                        <span v-for="tag in photo.tags" :key="tag.id" class="inline-flex items-center gap-x-0.5 rounded-md px-2 py-1 bg-blue-50 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                                    {{ tag.name }}
                                                <button type="button" @click="removeTag(tag)" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-blue-600/20">
                                                  <span class="sr-only">Remove</span>
                                                      <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-blue-700/50 group-hover:stroke-blue-700/75">
                                                        <path d="M4 4l6 6m0-6l-6 6"/>
                                                      </svg>
                                                      <span class="absolute -inset-1"/>
                                                </button>
                                          </span>
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
                                <a v-if="editingId !== photo.id" href="#" @click.prevent="editingId = photo.id" class="text-indigo-600 hover:text-indigo-900"
                                >Edit<span class="sr-only">, {{ photo.name }}</span></a
                                >
                                <button v-else @click="saveChanges(photo)">Save</button>                            </td>
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
