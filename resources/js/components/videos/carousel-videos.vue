<template>
    <carousel
        ref="myCarousel"
        :items-to-show="3.95"
        :wrap-around="true"
        :transition="500"
        @slide-end="onSlideChange"
    >
        <slide v-for="(video, index) in videos" :key="video.id">
            <video :src="video.url" preload="auto" @loadedmetadata="addVideo($event, index)" muted loop controls>
            </video>
        </slide>
        <template #addons>
            <Navigation />
        </template>
    </carousel>
</template>

<script setup>
import 'vue3-carousel/dist/carousel.css'
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel'
import {nextTick, onMounted, ref, watch} from "vue";

const videoElements = ref([]);
const myCarousel = ref(null);
const videos = ref([
    {
        id: 1,
        url: 'https://geez-production.com/storage/videos/EV2.mp4',
    },
    {
        id: 2,
        url: 'https://geez-production.com/storage/videos/EV1.mp4',
    },
    {
        id: 3,
        url: 'https://geez-production.com/storage/videos/EV4.mp4',
    },
    {
        id: 4,
        url: 'https://geez-production.com/storage/videos/EV2.mp4',
    },
    {
        id: 5,
        url: 'https://geez-production.com/storage/videos/EV1.mp4',
    },
    {
        id: 6,
        url: 'https://geez-production.com/storage/videos/EV4.mp4',
    },
]);


const currentIndexes = ref({
    currentSlideIndex : 0,
    prevSlideIndex : 0,
    slidesCount : videos.value.length,
    slidingToIndex : null,
});

const addVideo = (event, index) => {
    const videoElement = event.target;
    videoElement.addEventListener('canplay', () => {
        if (index === currentIndexes.value.currentSlideIndex && videoElement.paused) {
            videoElement.play();
        }
    });
    videoElements.value[index] = videoElement;
};

const onSlideChange = (event) => {
    currentIndexes.value = event;
    videoElements.value.forEach((videoElement, index) => {
        if (videoElement.readyState >= 3) {
            if (index === currentIndexes.value.currentSlideIndex) {
                videoElement.play();
            } else {
                videoElement.pause();
                videoElement.currentTime = 0;
            }
        }
    });
};
</script>

<style scoped>
.carousel__slide {
    padding: 5px;
}

.carousel__viewport {
    perspective: 2000px;
}

.carousel__track {
    transform-style: preserve-3d;
}

.carousel__slide--sliding {
    transition: 0.5s;
}

.carousel__slide {
    opacity: 0.9;
    transform: rotateY(-20deg) scale(0.9);
}

.carousel__slide--active ~ .carousel__slide {
    transform: rotateY(20deg) scale(0.9);
}

.carousel__slide--prev {
    opacity: 1;
    transform: rotateY(-10deg) scale(0.95);
}

.carousel__slide--next {
    opacity: 1;
    transform: rotateY(10deg) scale(0.95);
}

.carousel__slide--active {
    opacity: 1;
    transform: rotateY(0) scale(1.1);
}

.navigation-container {
    display: flex;
    justify-content: space-between; /* Optional: To add space between the buttons */
}
</style>
