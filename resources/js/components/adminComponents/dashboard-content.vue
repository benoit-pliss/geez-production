<script setup>
import StoreImage from "./store-image.vue";
import PhotosTables from "./tables/photos-tables.vue";
import {getListePhotosWithTags} from "../../services/Photo-service.js";
import {onMounted, ref} from "vue";
import Paginator from "./tables/paginator.vue";

const PhotosListe = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const lastPage = ref(0);
const total = ref(0);
const to = ref(0);

const getPhotos = async () => {
    isLoading.value = true;
    await getListePhotosWithTags(currentPage.value)
        .then(response => {
            console.log(response.data.photos);
            PhotosListe.value = response.data.photos.data;
            lastPage.value = response.data.photos.last_page;
            total.value = response.data.photos.total;
            to.value = response.data.photos.to;

        })
        .finally(() => {
            isLoading.value = false;
        });
};

const changePage = (newPage) => { // Nouveau
    currentPage.value = newPage;
    getPhotos();
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
    <paginator v-model="currentPage" :to="to" :total="total" :last-page="lastPage" @change="changePage" />
</template>

<style scoped>
.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Adjust this value according to your needs */
}
</style>
