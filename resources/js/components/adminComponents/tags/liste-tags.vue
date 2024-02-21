<script setup>
import CreateTagsDialog from "../../dialog/create-tags/create-tags-dialog.vue";
import dialogService from "../../../services/dialogService.js";
import {getTags} from "../../../services/tagsService.js";
import {onMounted, ref, watch, watchEffect} from "vue";

const Tags = ref([]);
const selectedTags = ref([]);

const color = 'blue';

const refreshTags = () => {
    console.log('refreshing tags');
    return getTags().then(response => {
        console.log(response.data);
        Tags.value = response.data.tags;
        console.log(Tags.value);
    });
};

onMounted(() => {
    refreshTags();
});

const openCreateTagsDialog = () => {
    dialogService.openDialog(CreateTagsDialog, {}, refreshTags);
};


const selectTag = (tag) => {
    if (!selectedTags.value.find(t => t === tag)) {
        selectedTags.value.push(tag);
        console.log(selectedTags.value)
    } else {
        selectedTags.value = selectedTags.value.filter(t => t !== tag);
    }
};

const removeTag = (tag) => {
    selectedTags.value = selectedTags.value.filter(t => t !== tag);
};

</script>

<template>
    <div class="flex flex-col w-full">
        <fieldset>
            <legend class="text-base font-semibold leading-6 text-gray-900">Tags</legend>

            <div class="flex flex-wrap w-full">
                <div v-for="(tag, index) in Tags" :key="index" class="relative flex flex-row items-start py-4 pr-2">

                    <span v-if="!selectedTags.find(t => t === tag)" @click="selectTag(tag)"
                          class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-700/10 cursor-pointer">
                        {{ tag.name }}
                    </span>



                    <span v-if="selectedTags.find(t => t === tag)"
                          class="inline-flex items-center gap-x-0.5 rounded-md px-2 py-1 bg-blue-50 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10"
                    >
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
            </div>
        </fieldset>

        <div class="mt-6">
            <button type="button" @click="openCreateTagsDialog"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus-visible:outline focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">
                Add Tags
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
