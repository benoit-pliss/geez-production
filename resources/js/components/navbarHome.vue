<template>
  <header class="sticky md:fixed top-0 z-20 w-full">
    <nav class="flex items-center justify-center transition-all duration-200" 
    aria-label="Global">
      <div id="header" class="flex w-full md:w-fit bg-white md:rounded-b-3xl px-8 pb-4 transition-all duration-300 items-center justify-center">
        <a href="/home" class="-m-1.5 p-1.5">
          <span class="sr-only">Geez Production</span>
          <img id="nav-logo" class="h-32 w-auto transition-all duration-300"
          src="../../img/logo/logo-geez-dark.png" alt="Logo Geez Production" />
        </a>
      </div>
    </nav>
  </header>
</template>

<script setup>

// Fonction pour vérifier la position de défilement
function checkScroll() {
    const header = document.getElementById('header');
    const navLogo = document.getElementById('nav-logo');
    // Vérifie si la page a été défilée vers le bas depuis le haut
    if (window.scrollY > 0) {
        header.classList.remove('pb-4');
        header.classList.add('pb-2');

        navLogo.classList.add('h-24');
        navLogo.classList.remove('h-32');
    } else {
        header.classList.add('pb-4');
        header.classList.remove('pb-2');

        navLogo.classList.add('h-32');
        navLogo.classList.remove('h-24');
    }
}

// Écouteur d'événement pour le défilement
window.addEventListener('scroll', checkScroll);

</script>

