<script setup>
import { XMarkIcon, PlusIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    label : String,
    color : String,
    id : Number,
    onClick : Function,
    type : String,
    isDashboard : Boolean || false,
    dark : { type: Boolean, default: false },
});
const colors = [
    'fill-red-500',
    'fill-yellow-500',
    'fill-green-500',
    'fill-blue-500',
    'fill-indigo-500',
    'fill-purple-500',
    'fill-pink-500'
];
function getRandColor() {
    return colors[Math.floor(Math.random() * colors.length)];
}
</script>

<template>
    <span
        class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium backdrop-blur-md"
        :class="[
            dark ? 'text-white bg-white/20 hover:bg-white/30' : 'text-gray-900 bg-black/10 hover:bg-black/20',
            !isDashboard ? 'cursor-pointer' : ''
        ]"
        @click="!isDashboard && onClick(id)"
    >
        <svg class="h-1.5 w-1.5" viewBox="0 0 6 6" aria-hidden="true" :class="'fill-' + color + '-500' || getRandColor()">
            <circle cx="3" cy="3" r="3" />
        </svg>
        {{ label }}
        <XMarkIcon v-if="type === 'remove' && !isDashboard" class="h-3 w-3" aria-hidden="true" />
        <PlusIcon v-if="type !== 'remove' && !isDashboard" class="h-3 w-3" aria-hidden="true" />
    </span>
</template>

<style scoped>

</style>


