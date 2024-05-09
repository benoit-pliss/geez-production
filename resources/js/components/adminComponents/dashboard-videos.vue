<script setup>
import StoreVideos from "./store-videos.vue";
import VideosTables from "./tables/videos-tables.vue";
import {getVideoWithTags} from "../../services/videosService.js";
import {onMounted, ref} from "vue";
import Paginator from "./tables/paginator.vue";

const VideosListe = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const lastPage = ref(0);
const total = ref(0);
const to = ref(0);
const searchName = ref('');

const getVideos = async () => {
    isLoading.value = true;
    await getVideoWithTags(currentPage.value, 10, searchName.value)
        .then(response => {
            VideosListe.value = response.data.rows.data;
            lastPage.value = response.data.rows.last_page;
            total.value = response.data.rows.total;
            to.value = response.data.rows.to;

        })
        .finally(() => {
            isLoading.value = false;
        });
};

const changePage = (newPage) => { // Nouveau
    currentPage.value = newPage;
    getVideos();
};

const updateListe = (name) => {
    searchName.value = name;
    getVideos();
};

onMounted(() => {
    getVideos();
});

</script>

<template>
  <StoreVideos/>
    <VideosTables :photos="VideosListe" @searchName="updateListe"/>
    <paginator v-model="currentPage" :to="to" :total="total" :last-page="lastPage" @change="changePage" />
</template>

<style scoped>

</style>
