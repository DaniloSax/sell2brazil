<template>
  <q-page padding>
    <div class="text-overline text-uppercase">Carrinho de compras</div>
    <q-separator class="q-mb-lg" />

    <div class="q-gutter-sm">
      <div class="text-h5">{{ orders.length }} Produtos no carrinho</div>

      <!-- orders -->
      <q-card v-for="(order, index) in orders" :key="index" class="q-mb-xl">
        <div
          class="
            q-ma-none
            bg-secondary
            text-white
            row
            justify-center
            text-h6 text-uppercase
          "
        >
          <span class="q-ma-sm">COD - {{ order.order_code }}</span>
          <span class="q-ma-sm">Data: {{ order.order_date }}</span>
          <span class="q-ma-sm">
            Total sem Desconto:
            {{ $filters.priceBR(order.total_amount_wihtout_discount) }}
          </span>
        </div>

        <q-card-section class="q-gutter-sm">
          <!-- produtos -->
          <q-card
            v-for="(product, index) in order.products"
            :key="index"
            @mouseenter="hover = index"
            @mouseleave="hover = null"
            class="q-my-sm"
            :class="[
              hover === index ? 'shadow-transition shadow-10 ' : 'shadow-0',
            ]"
          >
            <q-card-section horizontal>
              <img
                :src="product.image"
                alt="imagem produto"
                height="100"
                class="q-pa-md"
              />

              <div class="column col-md-8 col-sm-5 q-pa-md">
                <div class="text-h6">
                  {{ product.articleName }}
                </div>
                <div class="text-subtitle2">
                  {{ product.articleDescription }}
                </div>
              </div>

              <div class="col q-pa-md col-md-4 col-sm-5">
                <div class="text-subtitle2 text-primary">
                  Preço Unitário: {{ $filters.priceBR(product.unitPrice) }}
                </div>
                <div class="text-subtitle2">
                  Quantidade: {{ product.quantity }}
                </div>
                <div class="text-subtitle2 text-positive text-uppercase">
                  total:
                  {{ $filters.priceBR(product.quantity * product.unitPrice) }}
                </div>
              </div>
            </q-card-section>

            <q-card-actions class="row justify-end">
              <q-btn
                flat
                size="sm"
                color="negative"
                icon="close"
                label="Remover"
              />
            </q-card-actions>
            <q-separator spaced inset />
          </q-card>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import { api } from "src/boot/axios";
import { onMounted, ref } from "@vue/runtime-core";

export default {
  setup(props) {
    const orders = ref([]);
    const hover = ref(null);

    onMounted(async () => {
      const { data } = await api.get("orders");

      orders.value = data.orders;

      console.log(orders.value);
    });

    return { orders, hover };
  },
};
</script>

<style>
</style>
