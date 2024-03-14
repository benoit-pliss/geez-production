<script>
// Import Swiper core and required modules
import { Navigation, Pagination, Scrollbar, A11y, EffectCoverflow } from 'swiper/modules';

// Import Swiper Vue.js components
import {Swiper, SwiperSlide} from 'swiper/vue';

// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';

import 'swiper/css/effect-coverflow';
import 'swiper/css/pagination';

import {onMounted, ref} from "vue";

// Import Swiper styles
export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    methods: {
        updateSwiperHeight() {
            this.mySwiper.updateAutoHeight();
        }
    },
    setup() {
        const mySwiper = ref(null);
        const videos = ref([]);

        const onSwiper = (swiper) => {
            mySwiper.value = swiper;
        };

        const onSlideChange = () => {
            const swiper = mySwiper.value;
            if (swiper.activeIndex < videos.value.length) {
                const activeSlideVideo = videos.value[swiper.activeIndex];
                activeSlideVideo.play();

                videos.value.forEach((video, index) => {
                    if (index !== swiper.activeIndex) {
                        video.pause();
                        video.currentTime = 0; // Réinitialise la position de lecture de la vidéo
                    }
                });
            }
        };
        const reachEnd = () => {
            // reset the swiper
            mySwiper.value.slideTo(0);

            // Réinitialiser et relancer la première vidéo
            videos.value.forEach((video, index) => {
                video.pause();
                video.currentTime = 0;
                if (index === 0) {
                    video.play();
                }
            });
        };

        onMounted(() => {
            //lancer la première vidéo
            videos.value[0].play();

            // Précharger les vidéos
            videos.value.forEach((video) => {
                const videoElement = document.createElement('video');
                videoElement.src = video.url;
                videoElement.preload = 'auto';
            });
        });

        return {
            mySwiper,
            videos,
            onSwiper,
            onSlideChange,
            reachEnd,
            modules: [Navigation, Pagination, Scrollbar, A11y, EffectCoverflow]
        };
    },

    data() {
        return {
            video : ref(),
            videos : [
                {
                    id: 1,
                    url: 'https://geez-production.com/storage/videos/EV2.mp4'
                },
                {
                    id: 2,
                    url: 'https://geez-production.com/storage/videos/EV1.mp4'
                },
                {
                    id: 3,
                    url: 'https://geez-production.com/storage/videos/EV4.mp4'
                },
                {
                    id: 4,
                    url: 'https://geez-production.com/storage/videos/EV2.mp4'
                },
                {
                    id: 5,
                    url: 'https://geez-production.com/storage/videos/EV1.mp4'
                },
                {
                    id: 6,
                    url: 'https://geez-production.com/storage/videos/EV4.mp4'
                }
            ]
        };
    },
};



</script>





<template>
    <div class="flex items-center justify-center h-screen bg-gray-800 text-white font-bold text-2xl">
        <swiper
            ref="mySwiper"
            :modules="modules"
            :slides-per-view="3"
            :space-between="50"
            navigation
            pagination
            :scrollbar="{ draggable: false, hide : true , el: '.swiper-scrollbar' }"
            @swiper="onSwiper"
            @slideChange="onSlideChange"
            @reachEnd="reachEnd"
            centeredSlide
            :effect="'coverflow'"
            :grabCursor="true"
            :centeredSlides="true"
            :coverflowEffect="{
            rotate: 50,
            stretch: 30,
            depth: 200,
            modifier: 1,
            slideShadows: true
            }"
            :autoHeight="true"

        >
            <swiper-slide v-for="video in videos" :key="video.id">
                <video ref="videos" class="video-slide" loop muted v-bind="video" preload="auto" controls @loadedmetadata="updateSwiperHeight">
                    <source :src="video.url" type="video/mp4">
                    <track kind="captions" :src="video.captions" srclang="fr" label="French captions">
                </video>
            </swiper-slide>
        </swiper>
    </div>
</template>

<style scoped>
.swiper {
    width: 100%;
    height: auto;
}

.swiper-slide {
    text-align: center;
    font-size: 18px;
    background: #fff;
}

.swiper .swiper-slide {
    height: 300px;
    line-height: 300px;
}

.swiper .swiper-slide:nth-child(2n) {
    height: auto;
    line-height: 500px;
}
</style>
