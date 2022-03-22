<template>
  <q-layout view="lHh Lpr lFf" class="bg-app">
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
          <q-btn
            flat
            round
            color="primary"
            icon="shopping_cart"
            :to="{ name: 'cart' }"
          />
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

<style>
.bg-app {
  background: #d3cce3;
  background: -webkit-linear-gradient(to right, #e9e4f0, #d3cce3);
  background: linear-gradient(to right, #e9e4f0, #d3cce3);
}
</style>
