<script setup>
import { inject, watch } from 'vue';
import Toast from './Toast.vue';
import {state as toastsState} from "../../services/notificationService.js";

const toasts = toastsState.toasts;

watch(() => toasts, (newToasts) => {
    console.log(newToasts);
});
</script>

<template>
    <div class="flex flex-col-reverse">
        <toast v-for="toast in toasts"
               :key="toast.id"
               :type="toast.type"
               :message="toast.message"
        >

        </toast>
    </div>
</template>

<style scoped>

</style>
