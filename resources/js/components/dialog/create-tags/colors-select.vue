<script setup>
import {onMounted, ref, watch} from 'vue'
import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions} from '@headlessui/vue'
import {CheckIcon, ChevronUpDownIcon} from '@heroicons/vue/20/solid'

const emit = defineEmits(['update:modelValue'])

const colors = [
    {color: 'red', class: 'bg-red-500'},
    {color: 'yellow', class: 'bg-yellow-500'},
    {color: 'green', class: 'bg-green-500'},
    {color: 'blue', class: 'bg-blue-500'},
    {color: 'indigo', class: 'bg-indigo-500'},
    {color: 'purple', class: 'bg-purple-500'},
    {color: 'pink', class: 'bg-pink-500'}
];

const randomIntFromInterval = (min, max) => {
    return Math.floor(Math.random() * (max - min + 1) + min);
}

const selected = ref(colors[randomIntFromInterval(0, colors.length - 1)]);

onMounted(() => {
    emit('update:modelValue', selected.value.color)
})
watch(() => selected.value, (value) => {
    emit('update:modelValue', value.color)
})
</script>

<template>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="block text-sm font-medium leading-6 text-gray-900">Assigned to</ListboxLabel>
        <div class="relative mt-2">
            <ListboxButton
                class="relative w-full cursor-default rounded-md bg-white py-1.5 pl-3 pr-10 text-left text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
                <span class="flex items-center" v-if="selected">
                  <span :class="[selected.class, 'inline-block h-2 w-2 flex-shrink-0 rounded-full']"/>
                  <span class="ml-3 block truncate">{{ selected.color }}</span>
                </span>
                <span class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2">
                  <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions
                    class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                    <ListboxOption as="template" v-for="color in colors" :key="color.color" :value="color" v-slot="{ active, selected }">
                        <li :class="[active ? 'bg-indigo-600 text-white' : 'text-gray-900', 'relative cursor-default select-none py-2 pl-3 pr-9']">
                            <div class="flex items-center">
                                <span :class="[color.class, 'inline-block h-2 w-2 flex-shrink-0 rounded-full']" aria-hidden="true"/>
                                <span :class="[selected ? 'font-semibold' : 'font-normal', 'ml-3 block truncate']">
                                  {{ color.color }}
                                </span>
                            </div>

                            <span v-if="selected"
                                  :class="[active ? 'text-white' : 'text-indigo-600', 'absolute inset-y-0 right-0 flex items-center pr-4']">
                            <CheckIcon class="h-5 w-5" aria-hidden="true"/>
                          </span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<style scoped>

</style>
