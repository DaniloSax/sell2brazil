<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar class="bg-white">
        <img
          src="~assets/logo-sell2brazil.png"
          height="50"
          class="q-ma-md"
          alt="logo-sell2brazil"
        />

        <q-toolbar-title>
          <q-input
            rounded
            outlined
            v-model="search"
            type="text"
            label="Buscar"
          />
        </q-toolbar-title>

        <span class="text-dark row justify-start q-ml-md">
          <!-- <font-awesome-icon icon="fa-light fa-cart-shopping-fast" /> -->
          <q-btn flat round color="primary" icon="shopping_cart" />
          <q-btn flat round color="secondary" label="Entrar" />
        </span>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { defineComponent, ref } from "vue";

const linksList = [
  {
    title: "Docs",
    caption: "quasar.dev",
    icon: "school",
    link: "https://quasar.dev",
  },
  {
    title: "Github",
    caption: "github.com/quasarframework",
    icon: "code",
    link: "https://github.com/quasarframework",
  },
  {
    title: "Discord Chat Channel",
    caption: "chat.quasar.dev",
    icon: "chat",
    link: "https://chat.quasar.dev",
  },
  {
    title: "Forum",
    caption: "forum.quasar.dev",
    icon: "record_voice_over",
    link: "https://forum.quasar.dev",
  },
  {
    title: "Twitter",
    caption: "@quasarframework",
    icon: "rss_feed",
    link: "https://twitter.quasar.dev",
  },
  {
    title: "Facebook",
    caption: "@QuasarFramework",
    icon: "public",
    link: "https://facebook.quasar.dev",
  },
  {
    title: "Quasar Awesome",
    caption: "Community Quasar projects",
    icon: "favorite",
    link: "https://awesome.quasar.dev",
  },
];

export default defineComponent({
  name: "MainLayout",

  setup() {
    const search = ref("");

    return {
      essentialLinks: linksList,
      search,
    };
  },
});
</script>
