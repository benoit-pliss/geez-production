<script setup>
import {ref, watch} from 'vue'
import { Dialog, DialogPanel, TransitionChild, TransitionRoot } from '@headlessui/vue'
import ComboboxTags from "./combobox-tags.vue";
import {storeTag} from "../../../services/tagsService.js";
import notificationService from "../../../services/notificationService.js";
import ColorsSelect from "./colors-select.vue";

const open = ref(true)
const formdata = ref({
    name: '',
    description: '',
    ParentTag: '',
    color: ''
})
const handleSelectedTagUpdate = (value) => {
    formdata.value.ParentTag = value.id;
}

const props = defineProps({
    onUpdatedTags: Function
})
const saveTag = () => {
    storeTag(formdata.value)
        .then( (res) => {
            if (!res.data.success){
                notificationService.addToast('res.data.message', 'error');
            } else {
                open.value = false
                notificationService.addToast('Tag enregistré avec succès', 'success');
                props.onUpdatedTags && props.onUpdatedTags();
            }
        })
}

</script>

<template>
    <TransitionRoot as="template" :show="open" data-theme="light">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">

                            <form class="space-y-6" action="#" method="POST">
                                <div>
                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nouveau tag</label>
                                    <div class="mt-2">
                                        <input v-model="formdata.name" type="text" name="name" id="name" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Nom du tag" />
                                    </div>
                                </div>


                                <div>
                                    <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Ajouter une description</label>
                                    <div class="mt-2">
                                        <textarea v-model="formdata.description" rows="4" name="comment" id="comment" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Description du tag"></textarea>
                                    </div>
                                </div>

                                <colors-select @update:model-value="formdata.color = $event" />

                                <ComboboxTags @update:selectedTag="handleSelectedTagUpdate" />

                            </form>

                            <div class="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                                <button type="button" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:col-start-2" @click="saveTag()">Créer</button>
                                <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1 sm:mt-0" @click="open = false" ref="cancelButtonRef">Annuler</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

