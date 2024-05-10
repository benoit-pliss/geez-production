<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import { ref, defineEmits, defineProps } from 'vue'

const props = defineProps({
    total: Number,
    modelValue: Number,
    lastPage: Number
})

const emits = defineEmits(['update:modelValue', 'change'])

const currentPage = ref(props.modelValue)

const changePage = (newPage) => {

    if (newPage < 1 || newPage > props.lastPage) {
        return
    }

    currentPage.value = newPage
    emits('update:modelValue', newPage)
    emits('change', newPage)
}
</script>

<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" @click.prevent="changePage(currentPage - 1)" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Previous</span>
                <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
            </a>

            <a href="#" @click.prevent="changePage(currentPage + 1)" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                <span class="sr-only">Next</span>
                <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
            </a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Montrer
                    {{ ' ' }}
                    <span class="font-medium">
                        {{ (currentPage - 1) * 10 + 1 }}
                    </span>
                    {{ ' ' }}
                    à
                    {{ ' ' }}
                    <span class="font-medium">
                        {{ Math.min(currentPage * 10, total)}}
                    </span>
                    {{ ' ' }}
                    de
                    {{ ' ' }}
                    <span class="font-medium">
                        {{ total }}
                    </span>
                    {{ ' ' }}
                    résultats
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#" @click.prevent="changePage(currentPage - 1)" class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Previous</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </a>

                    <!--
                    <a href="#" @click.prevent="changePage(currentPage + 1)" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-gray-100 ring-1 ring-indigo-500 ring-inset focus:z-10 focus:outline-none focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2">
                        {{ currentPage }}
                    </a>-->
                    <template v-for="page in lastPage">
                        <a href="#" @click.prevent="changePage(page)" :class="[page === currentPage ? 'bg-gray-100' : 'bg-white', 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 ring-1 ring-gray-300 ring-inset focus:z-10 focus:outline-none focus:ring-indigo-500 focus:ring-2 focus:ring-offset-2']">
                            {{ page }}
                        </a>
                    </template>

                    <a href="#" @click.prevent="changePage(currentPage + 1)" class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </a>
                </nav>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
