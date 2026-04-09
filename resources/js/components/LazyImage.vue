<script setup>
import { ref } from 'vue';

const props = defineProps({
    src: { type: String, required: true },
    alt: { type: String, default: '' },
});

const loaded = ref(false);
</script>

<template>
    <div class="relative overflow-hidden">
        <!-- Skeleton shimmer -->
        <div
            v-if="!loaded"
            class="absolute inset-0 bg-gray-200 animate-pulse"
        />
        <!-- Image réelle -->
        <img
            :src="src"
            :alt="alt"
            loading="lazy"
            class="w-full h-auto object-cover transition-opacity duration-500"
            :class="loaded ? 'opacity-100' : 'opacity-0'"
            @load="loaded = true"
        />
    </div>
</template>
