<script setup>
import Toast from './Toast.vue';
import {watch} from "vue";

const props = defineProps({
    toasts: Array
});

watch(() => props.toasts, (toasts) => {
    console.log(toasts);
});

console.log("toast");
console.log(props.toasts);
console.log(props.toasts.length);
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
