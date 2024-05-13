<script setup>
import { onMounted, ref } from 'vue';

const iframeRef = ref(null);

onMounted(() => {
  window.addEventListener('message', (event) => {
    // Assurez-vous que le message provient de la source attendue
    if (event.origin === "https://eu.umami.is/share/SL2MPbicjEbtY4zV/geez-production.com") {
      const newHeight = event.data;
      if (newHeight && typeof newHeight === 'number') {
        iframeRef.value.style.height = `${newHeight}px`;
      }
    }
  });
});
</script>

<template>
    <iframe ref="iframeRef" src="https://eu.umami.is/share/SL2MPbicjEbtY4zV/geez-production.com" frameborder="0" width="100%" height="700" class="rounded-lg"></iframe>
</template>
