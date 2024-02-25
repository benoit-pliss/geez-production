<script setup>
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import Badge from '../components/Badge.vue';
</script>

<template>
    <div class="bg-white pb-24 sm:pb-32 pt-10" id="gallery">
        <div class="mx-auto px-6 lg:px-8">
            <div class="mx-auto max-w-xl text-center">
                <h2 class="text-lg font-semibold leading-8 tracking-tight text-indigo-600">Galerie</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Découvrez nos réalisations</p>
            </div>

            <div class="border-b border-gray-200 pb-5 sm:flex sm:items-center sm:justify-between mt-10">
                <div class="flex items-start gap-y-2 flex-col">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Filtres</h3>
                    <div class="flex mt-3 sm:mt-0 gap-x-2">
                        <!--Add all unselcted tags-->
                        <Badge v-for="tag in current_tags" :key="tag.id" :label="tag.name" :color="tag.color" :id="tag.id" :onClick="removeTag" type="remove"/>
                        <!--Message if no tag is selected-->
                        <span v-if="current_tags.length === 0" class="text-sm font-medium text-gray-500">Aucun filtre sélectionné</span>
                    </div>
                </div>


                <div class="mt-3 sm:ml-4 sm:mt-0">
                    <div class="flex rounded-md shadow-sm">
                        <div class="relative flex-grow focus-within:z-10">
                            <input list="tags" type="text" name="search-tag" id="search-tag" class="w-full rounded-none rounded-l-md border-0 px-3 py-1.5 text-sm leading-6 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 text-gray-900" placeholder="Ajouter un filtre" />
                            <datalist id="tags">
                                <option v-for="tag in load_tags" :key="tag.id" :value="tag.label"></option>
                            </datalist>
                        </div>
                        <button type="button" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50" id="add-tag-button">
                            <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="mx-auto mt-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
                <div class="-mt-8 sm:-mx-4 sm:columns-2 sm:text-[0] lg:columns-3">
                    <div v-for="image in images" :key="image.name" class="pt-8 sm:inline-block sm:w-full sm:px-4">
                        <!-- quand hover rendre visible la div des Badges-->
                        <div class="overflow-hidden transition duration-300 transform rounded-lg hover:scale-105"  v-on:mouseover="image.hidden = true" v-on:mouseleave="image.hidden = false">
                            <img :src="image.url" class="object-cover w-full h-auto" />
                                <div class="absolute inset-0 flex place-content-end justify-start flex-wrap-reverse gap-2 p-4" :class="{ 'hidden' : !image.hidden }">
                                    <Badge v-for="tag in image.tags" :key="tag.id" :label="tag.name" :color="tag.color" type="add" :onClick="addTag" :id="tag.id"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
import {getTags} from "../services/tagsService.js";
import {getListePhotosWithTags} from "../services/Photo-service.js";

export default {
    data () {
        return {
            load_tags : [],
            current_tags : [],

            images : [],
        };
    },
    methods: {

        addTag(tag_id) {
            const tag = this.load_tags.find(tag => tag.id === tag_id);
            if (tag) {
                this.current_tags.push(tag);
            }
        },

        removeTag(tag_id) {
            const index = this.current_tags.findIndex(tag => tag.id === tag_id);
            if (index !== -1) {
                this.current_tags.splice(index, 1);
            }
        },


        fetchTags() {
            getTags()
                .then(response => {
                    this.load_tags = response.data.tags;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        fetchImages() {
            getListePhotosWithTags()
                .then(response => {
                    this.images = response.data.photos;
                })
                .catch(error => {
                    console.log(error);
                });
        }

    },
    mounted() {
        document.getElementById('add-tag-button').addEventListener('click', () => {
            let searchTag = document.getElementById('search-tag');
            let tag = this.load_tags.find(tag => tag.label === searchTag.value);
            if (tag && !this.current_tags.find(t => t.id === tag.id)) {
                this.addTag(tag.id);
            }else {
                console.log('Tag not found or already added');
            }
            searchTag.value = '';

        });

        for (let image of this.images) {
            image.hidden = true;
        }

        this.fetchImages();
        this.fetchTags();

        console.log(this.load_tags);
    }
}
</script>

<style scoped>

</style>
