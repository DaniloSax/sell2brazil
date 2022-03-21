<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar class="bg-white">
        <Logotype />

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
          <q-btn flat color="primary" label="Entrar" :to="{ name: 'login' }" />
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
import Logotype from "src/components/Logotype.vue";

export default defineComponent({
  name: "MainLayout",
  setup() {
    const search = ref("");
    return {
      search,
    };
  },

  components: { Logotype },
});
</script>
