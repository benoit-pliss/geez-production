<template>
    <div data-theme="dark">
        <navbar></navbar>
        
    <div class="bg-gray-900 min-h-screen">
      <div class="mx-auto max-w-7xl px-6 py-24 sm:py-32 lg:px-8 lg:py-40">
        <div class="mx-auto max-w-4xl divide-y divide-white/10">
            <div class="flex items-center justify-between">
                <h1 class="text-4xl font-bold leading-10 tracking-tight text-white">Espace juridique</h1>
                <p class="text-base font-semibold leading-7 text-indigo-400">En date du 1er Janvier 2024</p>
            </div>
          <dl class="mt-10 space-y-6 divide-y divide-white/10">
            <Disclosure as="div" key="Conditions d'utilisation" class="pt-6" v-slot="{ open }">
              <dt>
                <DisclosureButton class="flex w-full items-start justify-between text-left text-white">
                  <span class="text-base font-semibold leading-7">Conditions d'utilisation</span>
                  <span class="ml-6 flex h-7 items-center">
                    <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true" />
                    <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true" />
                  </span>
                </DisclosureButton>
              </dt>
              <DisclosurePanel as="dd" class="mt-12 pr-12">
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Données personnelles : <span class="text-gray-300 font-normal">Nous nous engageons à respecter la confidentialité de vos données personnelles. Les informations que vous nous communiquez via ce site web sont utilisées uniquement dans le cadre de nos échanges commerciaux et ne sont en aucun cas transmises à des tiers sans votre consentement. <br/><br/> Conformément à la loi informatique et libertés, vous disposez d'un droit d'accès, de rectification et de suppression des données vous concernant. Pour exercer ce droit, veuillez nous contacter via le formulaire de contact.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Liens externes : <span class="text-gray-300 font-normal">Ce site peut contenir des liens vers des sites web externes. Nous ne pouvons être tenus responsables du contenu ou des pratiques de confidentialité de ces sites.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Limitation de responsabilité : <span class="text-gray-300 font-normal">Nous nous efforçons de fournir des informations précises et à jour sur ce site web, mais nous ne pouvons garantir l'exactitude, l'exhaustivité ou la pertinence des informations fournies. En utilisant ce site, vous acceptez de ne pas nous tenir responsables des erreurs ou omissions éventuelles dans le contenu.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Droit applicable et juridiction : <span class="text-gray-300 font-normal">Les présentes mentions légales sont régies par le droit français. En cas de litige, les tribunaux français seront seuls compétents.</span></p>
              </DisclosurePanel>
            </Disclosure>
            <Disclosure as="div" key="Politique de confidentialité" class="pt-6" v-slot="{ open }">
              <dt>
                <DisclosureButton class="flex w-full items-start justify-between text-left text-white">
                  <span class="text-base font-semibold leading-7">Politique de confidentialité</span>
                  <span class="ml-6 flex h-7 items-center">
                    <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true" />
                    <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true" />
                  </span>
                </DisclosureButton>
              </dt>
              <DisclosurePanel as="dd" class="mt-12 pr-12">
                <p class="text-base font-normal leading-7 text-gray-300 my-4">Nous vous remercions de votre visite sur notre site web. Dans le cadre de notre engagement envers la transparence et le respect de votre vie privée, nous souhaitons vous informer sur la manière dont nous collectons, utilisons et protégeons vos données personnelles.</p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Collecte de données personnelles : <span class="text-gray-300 font-normal">Nous collectons les informations que vous nous fournissez volontairement, telles que votre nom, votre adresse e-mail, lorsque vous utilisez nos services ou interagissez avec notre site web.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Utilisation des données : <span class="text-gray-300 font-normal">Les données personnelles que nous collectons sont utilisées pour traiter vos demandes, personnaliser votre expérience utilisateur, vous envoyer des communications marketing et améliorer nos services.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Partage des données : <span class="text-gray-300 font-normal">Nous ne partageons pas vos données personnelles avec des tiers, sauf si cela est nécessaire pour fournir nos services ou si nous y sommes légalement tenus.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Sécurité des données : <span class="text-gray-300 font-normal">Nous prenons des mesures techniques et organisationnelles pour protéger vos données personnelles contre tout accès non autorisé, divulgation, altération ou destruction.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Droits des utilisateurs : <span class="text-gray-300 font-normal">Vous avez le droit d'accéder à vos données personnelles, de les corriger, de les supprimer, de limiter leur traitement, de les transférer et de vous opposer à leur traitement.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Contact : <span class="text-gray-300 font-normal">Si vous avez des questions ou des préoccupations concernant notre politique de confidentialité ou la manière dont nous gérons vos données personnelles, veuillez nous contacter à l'aide du formulaire de contact.</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Mises à jour de la politique de confidentialité : <span class="text-gray-300 font-normal">Nous pouvons mettre à jour cette politique de confidentialité de temps à autre. La dernière version sera toujours disponible sur notre site web, avec la date de la dernière mise à jour.</span></p>
                <p class="text-base font-normal leading-7 text-gray-300 my-4">Nous vous remercions de votre confiance et de votre compréhension. Votre vie privée est importante pour nous, et nous nous engageons à protéger vos données personnelles.</p>
                </DisclosurePanel>
            </Disclosure>
            <Disclosure as="div" key="Mentions légales" class="pt-6" v-slot="{ open }">
              <dt>
                <DisclosureButton class="flex w-full items-start justify-between text-left text-white">
                  <span class="text-base font-semibold leading-7">Mentions légales</span>
                  <span class="ml-6 flex h-7 items-center">
                    <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true" />
                    <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true" />
                  </span>
                </DisclosureButton>
              </dt>
              <DisclosurePanel as="dd" class="mt-12 pr-12">
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Editeurs du site : <span class="text-gray-300 font-normal">Victor FOUQUET & Benoît PLISSONNIER</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Directeur de la publication : <span class="text-gray-300 font-normal">Ragee Moudawi</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4">Hébergeur : <span class="text-gray-300 font-normal">© 2004-2024 hostinger.fr - Hébergement Web & Nom de domaine</span></p>
                <p class="text-base font-semibold leading-7 text-gray-100 my-4 text-">Propriété intellectuelle : <span class="text-gray-300 font-normal">Le site est protégé par les droits de propriété intellectuelle et est la propriété exclusive de Victor FOUQUET & Benoît PLISSONNIER. La conception, le graphisme, le contenu, l’organisation de ce site sont des œuvres originales et sont l’entière propriété de Victor FOUQUET & Benoît PLISSONNIER. Toute reproduction, ou démarquage, total ou partiel, fait sans le consentement de l’auteur, ou de ses ayants droit, ou de ses ayants cause est illicite. Il en est de même pour la traduction, l’adaptation, l’arrangement par quelque procédé que ce soit (Loi 57298 du 11 mars 1957).</span></p>
              </DisclosurePanel>
            </Disclosure>
            <Disclosure as="div" key="Politique de cookies" class="pt-6" v-slot="{ open }">
              <dt>
                <DisclosureButton class="flex w-full items-start justify-between text-left text-white">
                  <span class="text-base font-semibold leading-7">Politique de cookies</span>
                  <span class="ml-6 flex h-7 items-center">
                    <PlusSmallIcon v-if="!open" class="h-6 w-6" aria-hidden="true" />
                    <MinusSmallIcon v-else class="h-6 w-6" aria-hidden="true" />
                  </span>
                </DisclosureButton>
              </dt>
              <DisclosurePanel as="dd" class="mt-12 pr-12">
                <p class="text-base font-normal leading-7 text-gray-300 my-4">🍪 Nous aimons les cookies... mais pas ceux que vous devez accepter en ligne ! Nous croyons en la transparence et le respect de la vie privée de nos visiteurs.</p>
                <p class="text-base font-normal leading-7 text-gray-300 my-4">C'est pourquoi nous avons pris la décision de ne pas utiliser de cookies sur notre site web. Vous pouvez naviguer en toute liberté, sans avoir à vous soucier de traqueurs ou de publicités ciblées. Nous croyons fermement que votre expérience en ligne devrait être aussi agréable que possible, sans compromettre votre vie privée.</p>
                <p class="text-base font-normal leading-7 text-gray-300 my-4">Votre confidentialité est importante pour nous. Même sans cookies, nous nous engageons à protéger vos informations personnelles et à fournir un environnement sûr et sécurisé pour toutes vos interactions avec notre site.</p>
                <p class="text-base font-normal leading-7 text-gray-300 my-4">Merci de votre confiance et de votre soutien. N'hésitez pas à nous contacter si vous avez des questions ou des préoccupations concernant notre politique de confidentialité ou toute autre chose. Nous sommes là pour vous aider !</p>

              </DisclosurePanel>
            </Disclosure>
          </dl>
        </div>
      </div>
    </div>
        <footer-page></footer-page>
    </div>
</template>

<script setup>
import Navbar from "../components/navbar.vue";
import FooterPage from "../components/footer-page.vue";
import {ref} from 'vue'

  import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
  import { MinusSmallIcon, PlusSmallIcon } from '@heroicons/vue/24/outline'
  
  const faqs = [
    {
      name: "Conditions d'utilisation",
      html:
        "I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.",
    },
    {
        name: "Politique de confidentialité",
      html:
        "I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.",
    },
    {
        name: "Mentions légales",
      html:
        "<strong> Editeur du site : </strong> Victor FOUQUET & Benoît PLISSONNIER <br/><strong> Directeur de la publication : </strong> Ragee Moudawi <br/><strong> Hébergeur : </strong> © 2004-2024 hostinger.fr - Hébergement Web & Nom de domaine <br/><strong> Adresse : </strong> 15, rue de la République, 75003 Paris <br/><strong> Téléphone : </strong> 01 23 45 67 89 <br/><strong> Email : </strong>"
    },
    {
        name: "Politique de cookies",
      html:
        "I don't know, but the flag is a big plus. Lorem ipsum dolor sit amet consectetur adipisicing elit. Quas cupiditate laboriosam fugiat.",
    },
    // More questions...
  ]
  </script>