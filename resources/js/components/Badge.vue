<script setup>

const props = defineProps({
    name: String,
    color: String
})
</script>

<template>
    <span
        class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium text-gray-900 ring-1 ring-inset"
    >
      <svg class="h-1.5 w-1.5"
           :class="`fill-` + color + `-500`"
           viewBox="0 0 6 6" aria-hidden="true">
        <circle cx="3" cy="3" r="3" />
      </svg>
      {{ name }}
    </span>
</template>

<style scoped>

</style>
