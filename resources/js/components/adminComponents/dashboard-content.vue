<script setup>

import StoreImage from "./store-image.vue";
import PhotosTables from "./tables/photos-tables.vue";
import {getListePhotosWithTags} from "../../services/Photo-service.js";
import {onMounted, ref} from "vue";

const PhotosListe = ref([]);
const isLoading = ref(false); // New loading state

const getPhotos = async () => {
    isLoading.value = true; // Start loading
    await getListePhotosWithTags()
        .then(response => {
            PhotosListe.value = response.data.photos;
        })
        .finally(() => {
            isLoading.value = false; // End loading
        });
};

onMounted(() => {
    getPhotos();
});

</script>

<template>
    <StoreImage @update:photos="getPhotos"/>
    <div class="spinner-container" v-if="isLoading">
        <span class="loading loading-spinner loading-md"></span>
    </div>
    <PhotosTables v-else :photos="PhotosListe" />
</template>

<style scoped>
.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Adjust this value according to your needs */
}
</style>
