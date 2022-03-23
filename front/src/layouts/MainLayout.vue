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
          >
            <q-badge color="red" floating>{{ order?.products?.length }}</q-badge>
          </q-btn>

          <q-btn flat color="primary" label="Entrar" :to="{ name: 'login' }" />
        </span>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>

    <!-- <q-footer reveal bordered class="row text-center bg-secondary text-white">
      <div class="q-pa-md col-xs-12 col-sm-6 col-md-5 col-lg-3 text-justify">
        A Popconvert é um software que busca inovar a captação de leads, criando
        uma base de inscritos fresca e qualificada, para aumentar a taxa de
        conversão e as vendas do seu site.
      </div>
      <div class="col q-pa-md">
        <div class="text-h6 text-uppercase">redes sociais</div>
        <div>test</div>
      </div>
    </q-footer> -->
  </q-layout>
</template>

<script>
import { computed, defineComponent, onMounted, ref } from "vue";
import Logotype from "src/components/Logotype.vue";
import { useStore } from "vuex";

export default defineComponent({
  name: "MainLayout",
  setup() {
    const search = ref("");
    const store = useStore();

    onMounted(() => {
      setTimeout(async () => await store.dispatch("cart/index"), 1000);
    });

    const order = computed(() => store.getters["cart/getOrder"]);

    return {
      search,
      order,
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
