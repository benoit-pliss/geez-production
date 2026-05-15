<script setup>
import VideosTables from "./tables/videos-tables.vue";
import StoreVideos from "./store-videos.vue";
import {getVideoWithTags, getBunnyVideoStatus} from "../../services/videosService.js";
import {onMounted, onUnmounted, ref, reactive} from "vue";
import {extractBunnyId} from "../../utils/bunnyHelpers.js";
import Paginator from "./tables/paginator.vue";

const VideosListe = ref([]);
const isLoading = ref(false);
const currentPage = ref(1);
const lastPage = ref(0);
const total = ref(0);
const to = ref(0);
const searchName = ref('');
const videoStatuses = reactive({});
let pollingTimer = null;

const fetchStatuses = async (videos) => {
    await Promise.allSettled(
        videos.map(async (video) => {
            const bunnyId = extractBunnyId(video.url);
            if (!bunnyId || videoStatuses[bunnyId]?.status === 3) return;
            try {
                const res = await getBunnyVideoStatus(bunnyId);
                videoStatuses[bunnyId] = { status: res.data.status, progress: res.data.encodeProgress };
            } catch {}
        })
    );
};

const schedulePolling = () => {
    clearInterval(pollingTimer);
    const isProcessing = (id) => {
        const s = videoStatuses[id];
        return s && s.status !== 3 && s.status >= 0 && s.progress < 100;
    };

    const processing = VideosListe.value.filter(v => {
        const id = extractBunnyId(v.url);
        return id && isProcessing(id);
    });
    if (!processing.length) return;

    pollingTimer = setInterval(async () => {
        await fetchStatuses(processing);
        const stillProcessing = processing.some(v => isProcessing(extractBunnyId(v.url)));
        if (!stillProcessing) clearInterval(pollingTimer);
    }, 5000);
};

const getVideos = async () => {
    isLoading.value = true;
    clearInterval(pollingTimer);
    try {
        const response = await getVideoWithTags(currentPage.value, 10, searchName.value);
        VideosListe.value = response.data.rows.data;
        lastPage.value = response.data.rows.last_page;
        total.value = response.data.rows.total;
        to.value = response.data.rows.to;
        await fetchStatuses(VideosListe.value);
        schedulePolling();
    } finally {
        isLoading.value = false;
    }
};

const changePage = (newPage) => {
    currentPage.value = newPage;
    getVideos();
};

const updateListe = (name) => {
    searchName.value = name;
    getVideos();
};

onMounted(() => getVideos());
onUnmounted(() => clearInterval(pollingTimer));
</script>

<template>
    <div>
        <StoreVideos class="mb-8" @videoUploaded="getVideos" />
        <VideosTables :photos="VideosListe" :statuses="videoStatuses" @searchName="updateListe"/>
        <paginator v-model="currentPage" :to="to" :total="total" :last-page="lastPage" @change="changePage" />
    </div>
</template>

<style scoped>

</style>
