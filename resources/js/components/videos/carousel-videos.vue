<script setup>

</script>

<template>
    <div class="carousel carousel-start rounded-box">

        <div class="carousel-item">
            <video class="" autoplay loop muted>
                <source src="https://geez-production.com/storage/videos/EV2.mp4" type="video/mp4">
            </video>
        </div>

        <div class="carousel-item">
            <video class="" autoplay loop muted>
                <source src="https://geez-production.com/storage/videos/EV4.mp4" type="video/mp4">
            </video>
        </div>

        <div class="carousel-item">
            <video class="" autoplay loop muted >
                <source src="https://geez-production.com/storage/videos/EV1.mp4" type="video/mp4">
            </video>
        </div>

    </div>
</template>

<style scoped>

.carousel-item video {
    max-width: 25%; /* Changez cette valeur selon vos besoins */
    max-height: 25%; /* Changez cette valeur selon vos besoins */
}

.carousel-item {
    //display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    width: 100%;
    background-color: #f5f5f5;
    border-radius: 10px;
    overflow: hidden;

}

</style>
