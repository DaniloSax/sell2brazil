<template>
  <q-page padding>
    <div>Produtos</div>
  </q-page>
</template>

<script>
import { onMounted } from "@vue/runtime-core";
import { useStore } from 'vuex';

export default {
  name: "Products",

  setup(props) {
const store = useStore()

    onMounted(() => {
      store.dispatch('product/index')
    });
  },
};
</script>

<style>
</style>
