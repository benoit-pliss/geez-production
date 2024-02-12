<script setup>
import CreateTagsDialog from "../../dialog/create-tags-dialog.vue";
import dialogService from "../../../services/dialogService.js";
import {getTags} from "../../../services/tagsService.js";
import {ref} from "vue";

const people = ref([]);

getTags().then(response => {
    console.log(response.data);
    people.value = response.data;
});

const openCreateTagsDialog = () => {
    dialogService.openDialog(CreateTagsDialog);
};
</script>

<template>
    <fieldset>
        <legend class="text-base font-semibold leading-6 text-gray-900">Members</legend>
        <div class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
            <div v-for="(person, personIdx) in people" :key="personIdx" class="relative flex items-start py-4">
                <div class="min-w-0 flex-1 text-sm leading-6">
                    <label :for="`person-${person.id}`" class="select-none font-medium text-gray-900">{{ person.name }}</label>
                </div>
                <div class="ml-3 flex h-6 items-center">
                    <input :id="`person-${person.id}`" :name="`person-${person.id}`" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
            </div>
        </div>
    </fieldset>

    <div class="mt-6">
        <button type="button" @click="openCreateTagsDialog" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus-visible:outline focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500">
            Add Tags
        </button>
    </div>
</template>

<style scoped>

</style>
