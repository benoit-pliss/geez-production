<script setup>
import {ref} from "vue";
import axios from "axios";

const file = ref(null);
const images = ref([]);

const onFileChange = (e) => {
    file.value = e.target.files[0];
};

async function upload() {
    if (!file.value) {
        return;
    }

    const formData = new FormData();
    formData.append('image', file.value);

    try {
        const response = await axios({
            method: 'post',
            url: '/api/upload',
            data: formData,
            headers: {'Content-Type': 'multipart/form-data'}
        });

        console.log(response.data);
        fetchImages(); // Fetch images again after a successful upload
    } catch (error) {
        console.log(error.response);
    }
}

</script>

<template>

<!--    file input-->

    <input type="file" name="image" id="image" class="form-control" @change="onFileChange" accept="image/*" />
    <button @click="submit" class="btn btn-primary">Submit</button>

</template>

<style scoped>

</style>
