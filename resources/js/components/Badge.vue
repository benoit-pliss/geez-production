<script setup>
import { XMarkIcon, PlusIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    label : String,
    color : String,
    id : Number,
    onClick : Function,
    type : String,
    isDashboard : Boolean || false
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
    <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-white backdrop-blur-md bg-black/10">
        <svg class="h-1.5 w-1.5" viewBox="0 0 6 6" aria-hidden="true" :class="'fill-' + color + '-500' || getRandColor()">
        <circle cx="3" cy="3" r="3" />
        </svg>
        {{ label }}

        <button v-if="type === 'remove' && !isDashboard" class="text-white group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-gray-500/30" @click="onClick(id)" :id="`button-tag-${id}`">
            <span class="sr-only">Remove</span>
            <XMarkIcon class="h-3.5 w-3.5" aria-hidden="true" />
            <span class="absolute -inset-1" />
        </button>

        <button v-if="type !== 'remove' && !isDashboard" class="text-white group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-gray-500/30" @click="onClick(id)" :id="`button-tag-${id}`">
            <span class="sr-only">Add</span>
            <PlusIcon class="h-3.5 w-3.5" aria-hidden="true" />
            <span class="absolute -inset-1" />
        </button>

    </span>
</template>

<style scoped>

</style>


