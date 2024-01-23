<script setup>

import router from "../router/index.js";
import store from "../store/index.js";
import {ref} from "vue";

const formData = ref({
    email: '',
    password: '',
});

const errors = ref({});

const login = () => {
    console.log(formData.value)
    axios.post('/api/login', formData.value)
        .then((res) => {
            errors.value = {}
            if (res.data.success) {
                localStorage.setItem('token', res.data.token)
                store.state.user.token = res.data.token
                router.push({name: 'dashboard'})
            } else {
                errors.value = res.data.errors
            }
        })
        .catch((err) => {
            if (err) {
                errors.value = err.response.data.errors
            }
        })
}

</script>

<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8" data-theme="light">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="../../img/logo/logogeez.png" alt="Geez Production" />
            <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Se connecter en tant qu'administrateur</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input id="email" name="email" type="email" autocomplete="email" v-model="formData.email" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                    </div>
                    <div class="mt-2">
                        <input id="password" name="password" type="password" autocomplete="current-password" v-model="formData.password" required="" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                    </div>
                </div>

                <div>
                    <button v-on:click="login" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Se Connecter</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
