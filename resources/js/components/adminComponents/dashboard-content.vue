<script setup>

import StoreImage from "./store-image.vue";
import PhotoEditing from "./photo-editing.vue";
import {Photos} from "../../Models/Photos.js";


const photo =  new Photos(
    'Image1',
    "Don't compromise on snack-carrying capacity with this lightweight and spacious bag. The drawstring top keeps all your favorite chips, crisps, fries, biscuits, crackers, and cookies secure.",
    'http://localhost:8000/storage/images/annie-spratt-STLEtlSj1i4-unsplash.jpg',
)
</script>

<template>
    <StoreImage />
    <PhotoEditing
        :photo="photo"
    />

</template>

<style scoped>

</style>
