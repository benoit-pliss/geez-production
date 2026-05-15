<template>
    <Teleport to="body">
        <div
            v-if="modelValue"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/90"
            @click.self="close"
        >
            <button
                class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10"
                @click="close"
            >
                <XMarkIcon class="h-8 w-8" />
            </button>

            <div class="max-w-[90vw] max-h-[90vh] flex items-center justify-center">
                <img
                    v-if="type === 'image'"
                    :src="src"
                    class="max-w-full max-h-[90vh] object-contain rounded-lg"
                    alt=""
                />
                <video
                    v-else-if="type === 'video'"
                    ref="videoRef"
                    :poster="poster"
                    class="max-w-[90vw] max-h-[90vh] rounded-lg"
                    controls
                    autoplay
                />
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { XMarkIcon } from '@heroicons/vue/20/solid'
import { watch, onUnmounted, ref } from 'vue'
import { attachHls } from '../composables/useHls.js'

const props = defineProps({
    modelValue: Boolean,
    type: { type: String, default: 'image' },
    src: String,
    poster: String,
})

const emit = defineEmits(['update:modelValue'])

const close = () => emit('update:modelValue', false)

const handleKeydown = (e) => {
    if (e.key === 'Escape') close()
}

let lightboxHls = null;

const videoRef = ref(null);

watch(videoRef, (el) => {
    lightboxHls?.destroy();
    lightboxHls = null;
    if (!el) return;

    // Pre-size the video element from the poster so HLS metadata loading causes no visible resize
    if (props.poster) {
        const img = new Image();
        img.onload = () => {
            const maxW = window.innerWidth * 0.9;
            const maxH = window.innerHeight * 0.9;
            const scale = Math.min(maxW / img.naturalWidth, maxH / img.naturalHeight, 1);
            el.style.width = Math.round(img.naturalWidth * scale) + 'px';
            el.style.height = Math.round(img.naturalHeight * scale) + 'px';
        };
        img.src = props.poster;
    }

    lightboxHls = attachHls(el, props.src);
    if (lightboxHls) lightboxHls.startLoad();
});

watch(() => props.modelValue, (val) => {
    if (val) {
        document.addEventListener('keydown', handleKeydown)
        document.body.style.overflow = 'hidden'
    } else {
        document.removeEventListener('keydown', handleKeydown)
        document.body.style.overflow = ''
        lightboxHls?.destroy();
        lightboxHls = null;
    }
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = ''
    lightboxHls?.destroy();
})
</script>
