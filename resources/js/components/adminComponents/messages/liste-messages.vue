<script setup>

import {onMounted, ref, defineEmits} from "vue";
import {getMessages, getArchivedMessages, deleteMessage, archiveMessage, readMessage} from "../../../services/messagesService.js";
import notificationService from "../../../services/notificationService.js";

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
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
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
                <td class="whitespace-nowrap py-5 px-3 py-5 text-sm text-gray-500">
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
                    <div class="flex items-center justify-center space-x-5 flex-col sm:flex-row">
                        <button 
                        href="#" 
                        v-if="message.read_at === null"
                        class="text-indigo-600 hover:text-indigo-900" 
                        @click="read(message.id)"><i class="fa-solid fa-check-to-slot"></i><span class="sr-only">, {{ message.name }}</span></button>
                        <button 
                        href="#" 
                        class="text-indigo-600 hover:text-indigo-900" 
                        @click="remove(message.id)"><i class="fa-solid fa-trash-can"></i><span class="sr-only">, {{ message.name }}</span></button>
                        <button 
                        href="#" 
                        v-if="archiveVue === false"
                        class="text-indigo-600 hover:text-indigo-900" 
                        @click="archive(message.id)"><i class="fa-solid fa-box-archive"></i><span class="sr-only">, {{ message.name }}</span></button>
                    </div>
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
