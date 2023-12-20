<script setup>

</script>

<template>

    <div class="navbar bg-base-100 px-1 py-1 fixed top-0 bg-base-100/25 text-base-content z-[2]">
        <div class="navbar-start lg:hidden">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[2] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="photography">Photographie</a></li>
                    <li><a href="audiovisual">Audiovisuel</a></li>
                    <li>
                        <a>En savoir plus</a>
                        <ul class="p-2">
                            <li><a>Nous contacter</a></li>
                            <li><a>Nous trouver</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="flex-1 justify-end lg:justify-start">
            <a class="ml-5 normal-case text-xl" href="home">GEEZ PRODUCTION</a>
        </div>
        <div class="hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li><a href="photography">Photographie</a></li>
                <li><a href="audiovisual">Audiovisuel</a></li>
                <li>
                    <details>
                        <summary>
                            En savoir plus
                        </summary>
                        <ul class="p-2 bg-base-100">
                            <li><a>Nous contacter</a></li>
                            <li><a>Nous trouver</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </div>
    </div>

</template>

<style scoped>

</style>
