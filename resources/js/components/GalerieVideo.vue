<template>
    <div class="bg-slate-950 pb-24 sm:pb-32 pt-24" id="gallery" ref="gallery">
        <div class="mx-auto px-6 lg:px-8">
            <div class="border-b border-slate-800 pb-5 sm:flex sm:items-center sm:justify-between mt-10">
                <div class="flex items-start gap-y-2 flex-col">
                    <h3 class="text-base font-semibold leading-6 text-white">Filtres</h3>
                    <div class="flex mt-3 sm:mt-0 gap-x-2">
                        <!--Add all unselcted tags-->
                        <Badge v-for="tag in current_tags" :key="tag.id" :label="tag.name" :color="tag.color" :id="tag.id" :onClick="removeTag" type="remove"/>
                        <!--Message if no tag is selected-->
                        <span v-if="current_tags.length === 0" class="text-sm font-medium text-gray-500">Aucun filtre sélectionné</span>
                    </div>
                </div>


                <Combobox as="div" v-model="selectedTags">
                    <div class="relative mt-2">
                        <ComboboxInput class="w-full rounded-md border-0 bg-slate-950 py-1.5 pl-3 pr-10 text-gray-300 shadow-sm ring-1 ring-inset ring-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-500 sm:text-sm sm:leading-6 outline-none" @change="query = $event.target.value" v-on:keydown.enter.prevent="addTag(filteredTags[0])" placeholder="Rechercher un tag" />
                        <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                            <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                        </ComboboxButton>

                        <ComboboxOptions v-if="filteredTags.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                            <ComboboxOption v-for="tag in filteredTags" :key="tag.id" :value="tag" as="template" v-slot="{ active }">
                                <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-gray-200' : 'text-gray-900']" v-on:click="addTag(tag)">
                                    {{ tag.name }}
                                </li>
                            </ComboboxOption>
                        </ComboboxOptions>
                    </div>
                </Combobox>
            </div>

            <div class="mx-auto mt-16 flow-root max-w-2xl sm:mt-20 lg:mx-0 lg:max-w-none">
                <div class="-mt-8 sm:-mx-4 sm:columns-2 sm:text-[0] lg:columns-2">
                    <div v-for="image in images" :key="image.name" class="pt-8 sm:inline-block sm:w-full sm:px-4">
                        <!-- quand hover rendre visible la div des Badges-->
                        <div class="overflow-hidden transition duration-300 transform rounded-lg"  v-on:mouseover="image.hidden = true" v-on:mouseleave="image.hidden = false">
                            <img :src="image.url" loading="lazy" class="object-cover w-full h-auto" alt="geez"/>
                                <div class="absolute inset-0 flex place-content-end justify-start flex-wrap-reverse gap-2 p-4" :class="{ 'hidden' : !image.hidden }">
                                    <Badge v-for="tag in image.tags" :key="tag.id" :label="tag.name" :color="tag.color" type="add" v-on:click="addTag(tag)" :id="tag.id"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Badge from '../components/Badge.vue';
import {getTags} from "../services/tagsService.js";
import {get30RandomPhotosWithTags, getListePhotosByTags} from "../services/Photo-service.js";
import {
  Combobox,
  ComboboxButton,
  ComboboxInput,
  ComboboxOption,
  ComboboxOptions,
} from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import {ref, onMounted, computed, watch} from 'vue'

const load_tags = ref([])
const current_tags = ref([])
const images = ref([])

const props = defineProps({
    pageTag: {
        type: String,
        required: false
    },
    scrollDown: {
        type: Function,
        required: false
    }
})

watch(() => props.pageTag, (newValue) => {
    if (newValue) {
        const tag = load_tags.value.find(tag => tag.name === newValue);
        if (tag) {
            replaceAllTag(tag);
        }
    }
})

const scrollDown = () => {
    document.getElementById('gallery').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

const replaceAllTag = (tag) => {
    current_tags.value = [];
    current_tags.value.push(tag);
    fetchImages();
    scrollDown();
}

const addTag = (tag) => {
    if (current_tags.value.find(t => t.id === tag.id)) {
        return;
    }
    if (tag) {
        current_tags.value.push(tag);
    }
    query.value = '';
    fetchImages();
}

const removeTag = (tag_id) => {
    const index = current_tags.value.findIndex(tag => tag.id === tag_id);
    if (index !== -1) {
        current_tags.value.splice(index, 1);
    }
    fetchImages();
}

const fetchTags = () => {
    getTags()
        .then(response => {
            load_tags.value = response.data.tags;
        })
        .catch(error => {
            console.log(error);
        });
}

const fetchImages = () => {
    if (current_tags.value.length > 0) {
        getListePhotosByTags(current_tags.value.map(tag => tag.id))
            .then(response => {
                images.value = response.data.photos;
            })
            .catch(error => {
                console.log(error);
            });
    } else {
        get30RandomPhotosWithTags()
            .then(response => {
                images.value = response.data.photos;
            })
            .catch(error => {
                console.log(error);
            });
    }
}


const query = ref('')

const selectedTags = ref(null)

const filteredTags = computed(() =>
    query.value === ''
        ? load_tags.value
        : load_tags.value.filter((tag) => {
            return tag.name.toLowerCase().includes(query.value.toLowerCase())
        })
)

onMounted(() => {
    for (let image of images.value) {
        image.hidden = true;
    }

    fetchImages();
    fetchTags();

})
</script>

<style scoped>

</style>
