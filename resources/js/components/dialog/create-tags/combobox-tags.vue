<script setup>
import {computed, ref, watch} from 'vue'
import { CheckIcon, ChevronUpDownIcon } from '@heroicons/vue/20/solid'
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue'
import {getTags} from '../../../services/tagsService.js'

const props = defineProps({
    isAssigned: {
        type: Boolean,
        required: false,
        default: true,
    },
})
const emit = defineEmits(['update:selectedTag'])
const tags = ref([])
getTags().then(response => {
    tags.value = response.data.tags;
});

const query = ref('')

const selectedTags = ref(null)

const filteredTags = computed(() =>
    query.value === ''
        ? tags.value
        : tags.value.filter((tag) => {
            return tag.name.toLowerCase().includes(query.value.toLowerCase())
        })
)

watch(selectedTags, (value) => {
    emit('update:selectedTag', value)
})
</script>

<template>
    <Combobox as="div" v-model="selectedTags">
        <ComboboxLabel v-if="isAssigned" class="block text-sm font-medium leading-6 text-gray-900">Assigner à un autre tag</ComboboxLabel>
        <div class="relative mt-2">
            <ComboboxInput class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @change="query = $event.target.value" :display-value="(person) => person?.name" />
            <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </ComboboxButton>

            <ComboboxOptions v-if="filteredTags.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                <ComboboxOption v-for="tag in filteredTags" :key="tag.id" :value="tag" as="template" v-slot="{ active, selected }">
                    <li :class="['relative cursor-default select-none py-2 pl-3 pr-9', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
            <span :class="['block truncate', selected && 'font-semibold']">
              {{ tag.name }}
            </span>

                        <span v-if="selected" :class="['absolute inset-y-0 right-0 flex items-center pr-4', active ? 'text-white' : 'text-indigo-600']">
              <CheckIcon class="h-5 w-5" aria-hidden="true" />
            </span>
                    </li>
                </ComboboxOption>
            </ComboboxOptions>
        </div>
    </Combobox>
</template>

<style scoped>

</style>
