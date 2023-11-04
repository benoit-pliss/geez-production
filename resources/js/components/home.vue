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
            <a class="btn btn-ghost normal-case text-xl" href="home">GEEZ PRODUCTION</a>
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

    <div class="hero min-h-screen header-image">
        <div class="hero-overlay bg-opacity-60"></div>
        <div class="hero-content text-center text-neutral-content flex flex-col justify-center gap-20"> 
            <div class="flex flex-col w-full lg:flex-row">
                <div class="max-w-xl">
                    <h1 class="text-5xl font-bold">Photographie</h1>
                    <p class="py-6 text-sm">Nous vous souhaitons la bienvenue sur notre site web, nous espèrons que vous
                        vous y
                        touverez toutes les informations dont vous avez besoin. Toutefois, si vous avez des questions,
                        n'hésitez pas à nous contacter ! C'est avec plaisir que nous vous répondrons.</p>
                </div>
                <div class="divider lg:divider-horizontal text-neutral-content"></div>
                <div class="max-w-xl">
                    <h1 class="text-5xl font-bold">Audiovisuel</h1>
                    <p class="py-6 text-sm">Nous vous souhaitons la bienvenue sur notre site web, nous espèrons que vous
                        vous y
                        touverez toutes les informations dont vous avez besoin. Toutefois, si vous avez des questions,
                        n'hésitez pas à nous contacter ! C'est avec plaisir que nous vous répondrons.</p>
                </div>
                
            </div>

            <div class="flex flex-col justify-center gap-5">
                <div class="flex justify-center gap-10">
                    <a href="https://instagram.com/gee.z_prod?igshid=OGQ5ZDc2ODk2ZA==" target="_blank" class="text-4xl"><i
                            class="fa-brands fa-instagram"></i></a>
                    <a href="https://www.tiktok.com/@gee.z_prod?_t=8fxkxEsPeC0&_r=1" target="_blank" class="text-4xl"><i
                            class="fa-brands fa-tiktok"></i></a>
                </div>
                <p class=" text-sm">Retrouvez-nous également sur les réseaux sociaux !</p>
            </div>

            
            

        </div>
    </div>


    <div class="flex justify-center items-center">

        <div class="my-10 flex gap-10 flex-wrap justify-center lg:gap-20 lg:flex-nowrap">

            <div class="stat">
                <div class="stat-figure">
                    <i class="fa-regular fa-heart text-3xl"></i>
                </div>
                <div class="stat-title">Likes</div>
                <div class="stat-value">15.4k</div>
                <div class="stat-desc">37% plus que le mois dernier</div>
            </div>


            <div class="stat">
                <div class="stat-figure">
                    <i class="fa-solid fa-bolt text-3xl"></i>
                </div>
                <div class="stat-title">Visites totales</div>
                <div class="stat-value">1,200</div>
                <div class="stat-desc">19% plus que le mois dernier</div>
            </div>


            <div class="stat">
                <!--<div class="stat-figure">
                    <div class="avatar">
                        <div class="w-16 rounded-full">
                            <img src="../../img/pp.jpg" />
                        </div>
                    </div>
                </div>-->
                <div class="stat-figure">
                    <i class="fa-solid fa-chess-king text-3xl"></i>
                </div>
                <div class="stat-title">Ragee Moudawi</div>
                <div class="stat-value">100%</div>
                <div class="stat-desc">Fondateur de Geez Production</div>
            </div>

        </div>

    </div>


    <footer class="footer p-10 bg-base-100 text-base-content">
        <nav>
            <header class="footer-title">Services</header>
            <a class="link link-hover">Photographe</a>
            <a class="link link-hover">Videaste</a>
            <a class="link link-hover">Bien plus...</a>
        </nav>
        <nav>
            <header class="footer-title">Geez Production</header>
            <a class="link link-hover">À propos</a>
            <a class="link link-hover">Contact</a>
            <a class="link link-hover">Carrière</a>
            <a class="link link-hover">Blog</a>
        </nav>
        <nav>
            <header class="footer-title">Juridique</header>
            <a class="link link-hover">Conditions d'utilisation</a>
            <a class="link link-hover">Politique de confidentialité</a>
            <a class="link link-hover">Mentions légales</a>
            <a class="link link-hover">Politique de cookies</a>
        </nav>
    </footer>
    <footer class="footer px-10 py-4 bg-base-100 text-base-content">
        <aside class="items-center grid-flow-col gap-4 order-last md:order-first">
            <i class="fa-solid fa-clapperboard text-2xl"></i>
            <p>© 2023 Geez Production - Tous droits réservés</p>
        </aside>
        <nav class="md:place-self-center md:justify-self-end">
            <div class="grid grid-flow-col gap-4">
                <a href="https://instagram.com/gee.z_prod?igshid=OGQ5ZDc2ODk2ZA==" target="_blank" class="text-xl"><i
                    class="fa-brands fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@gee.z_prod?_t=8fxkxEsPeC0&_r=1" target="_blank" class="text-xl"><i
                    class="fa-brands fa-tiktok"></i></a>
        </div>
    </nav>
</footer></template>

<style scoped>.header-image {
    background-image: url('../../img/pexels-aleksandar-pasaric-1820770.jpg');
}</style>