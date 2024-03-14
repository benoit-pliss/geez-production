<script setup>

import {onMounted, ref} from "vue";
import {getMessages, getArchivedMessages, deleteMessage, archiveMessage, readMessage} from "../../../services/messagesService.js";
import notificationService from "../../../services/notificationService.js";
import {
    CheckCircleIcon,
    ArchiveBoxIcon,
    TrashIcon,
    ChevronDownIcon,
 } from "@heroicons/vue/24/outline";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";

const messages = ref([]);
const archiveVue = ref(false);

const refreshMessages = () => {
    if (archiveVue.value === false) {
        return getMessages().then(response => {
            messages.value = response.data.entity;
            console.log(response.data.entity);
        });
    } else {
        return getArchivedMessages().then(response => {
            messages.value = response.data.entity;
            console.log(response.data);
        });
    }
};

onMounted(() => {
    refreshMessages();
});

const archive = (id) => {

    console.log(id);
    archiveMessage(id).then((res) => {
        notificationService.addToast(res.data.message, 'success');
        refreshMessages();
    })
    .catch((err) => {
        notificationService.addToast(err.response.data.message, 'error');
    });
};

const remove = (id) => {

    console.log(id);
    deleteMessage(id).then((res) => {
        notificationService.addToast(res.data.message, 'success');
        refreshMessages();
    })
    .catch((err) => {
        notificationService.addToast(err.response.data.message, 'error');
    });
};

const read = (id) => {

    console.log(id);
    readMessage(id).then((res) => {
        notificationService.addToast(res.data.message, 'success');
        refreshMessages();
    })
    .catch((err) => {
        notificationService.addToast(err.response.data.message, 'error');
    });
};


</script>

<template>
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold leading-6 text-gray-900">Messages</h1>
        <p v-if="archiveVue === false" class="mt-2 text-sm text-gray-700">Tous les messages reçus</p>
        <p v-else class="mt-2 text-sm text-gray-700">Tous les messages archivés</p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button
            v-if="archiveVue === false"
            @click="archiveVue = true; refreshMessages()"
            type="button"
            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"><i class="fa-solid fa-box-archive"></i> Archives</button>
        <button
            v-else
            @click="archiveVue = false; refreshMessages()"
            type="button"
            class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Boite de réception</button>

      </div>
    </div>
    <div class="mt-8 flow-root">
      <div class="-mx-4 -my-2  sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0"></th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nom</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Adresse email</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Téléphone</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Message</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                  <span class="sr-only">...</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="message in messages" :key="message.id">
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    <div class="flex items-center justify-center space-x-5 flex-col sm:flex-row">
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
                        v-if="message.read_at === null">Nouveau</span>
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20"
                        v-else>Lu</span>
                    </div>

                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    <div class="font-medium text-gray-900">{{ message.firstname }} {{ message.lastname }}</div>
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                      <div class="mt-1 text-gray-500">{{ message.email }}</div>
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                      <div class="mt-1 text-gray-500">{{ message.phone }}</div>
                </td>
                <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                    <!-- Display the message and return to the next line if it is too long -->
                    <div class="mt-1 text-gray-500 whitespace-pre-wrap">{{ message.message }}</div>
                </td>
                <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">

                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                        <MenuButton class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Options
                            <ChevronDownIcon class="-mr-1 h-4 w-4 text-gray-400" aria-hidden="true" />
                        </MenuButton>
                        </div>

                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute right-0 z-30 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }" v-if="message.read_at === null">
                                <a href="#"
                                   @click="read(message.id)"
                                :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                    <CheckCircleIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                    Marquer comme lu
                                </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <a href="#" @click="archive(message.id)" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                    <ArchiveBoxIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                    Archiver
                                </a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                <a href="#" @click="remove(message.id)" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'group flex items-center px-4 py-2 text-sm']">
                                    <TrashIcon class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                                    Supprimer
                                </a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                        </transition>
                    </Menu>


                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</template>

<style scoped>

</style>
