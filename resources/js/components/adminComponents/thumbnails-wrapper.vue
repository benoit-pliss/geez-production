<template>
    <div class="thumbnails-wrapper">
        <div v-for="thumbnail in thumbnails" :key="thumbnail" class="thumbnail">
            <img :src="thumbnail" alt="" @click="selectThumbnail(thumbnail)" />
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'

const props = defineProps({
    thumbnails: Array
})

const emits = defineEmits(['select'])

const selectThumbnail = (thumbnail) => {
    emits('select', thumbnail)
}
</script>

<style scoped>
.thumbnail {
    width: 200px;
    object-fit: cover;
    margin: 10px;
    cursor: pointer;
}
</style>
