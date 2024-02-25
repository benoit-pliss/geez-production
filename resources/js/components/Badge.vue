<script setup>
const props = defineProps({
    label : String,
    color : String,
    id : Number,
    onClick : Function,
    type : String
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
    <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset ring-gray-200 bg-white/70">
        <svg class="h-1.5 w-1.5" viewBox="0 0 6 6" aria-hidden="true" :class="color || getRandColor()">
        <circle cx="3" cy="3" r="3" />
        </svg>
        {{ label }}

        <button v-if="type === 'remove'" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-gray-500/20" @click="onClick(id)" :id="`button-tag-${id}`">
            <span class="sr-only">Remove</span>
            <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-gray-600/50 group-hover:stroke-gray-600/75">
                <path d="M4 4l6 6m0-6l-6 6" />
            </svg>
            <span class="absolute -inset-1" />
        </button>

        <button v-else class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-gray-500/20" @click="onClick(id)" :id="`button-tag-${id}`">
            <span class="sr-only">Add</span>
            <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-gray-600/50 group-hover:stroke-gray-600/75">
                <path d="M4 7h6m-3-3v6" />
            </svg>
            <span class="absolute -inset-1" />
        </button>
        
    </span>
</template>

<style scoped>

</style>


