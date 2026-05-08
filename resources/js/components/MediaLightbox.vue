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
                    :src="src"
                    :poster="poster"
                    class="max-w-full max-h-[90vh] rounded-lg"
                    controls
                    autoplay
                />
            </div>
        </div>
    </Teleport>
</template>

<script setup>
import { XMarkIcon } from '@heroicons/vue/20/solid'
import { watch, onUnmounted } from 'vue'

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

watch(() => props.modelValue, (val) => {
    if (val) {
        document.addEventListener('keydown', handleKeydown)
        document.body.style.overflow = 'hidden'
    } else {
        document.removeEventListener('keydown', handleKeydown)
        document.body.style.overflow = ''
    }
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeydown)
    document.body.style.overflow = ''
})
</script>
