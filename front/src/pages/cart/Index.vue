<template>
  <q-page padding>
    <div class="text-overline text-uppercase">Carrinho de compras</div>

    <q-separator class="q-mb-lg" />

    <div class="text-h5">{{ orders.length }} Compras pendentes</div>

    <!-- orders -->
    <q-card
      flat
      bordered
      v-for="(order, index) in orders"
      :key="index"
      class="q-mb-lg"
    >
      <q-item class="bg-secondary text-white">
        <q-item-section>
          <q-item-label> COD - {{ order.order_code }} </q-item-label>
        </q-item-section>

        <q-item-section>
          <q-item-label> Data: {{ order.order_date }} </q-item-label>
        </q-item-section>

        <q-item-section>
          <q-item-label>
            TOTAL SEM DESCONTO:
            {{ $filters.priceBR(order.total_amount_wihtout_discount) }}
          </q-item-label>
        </q-item-section>

        <q-item-section>
          <q-item-label>
            <q-btn color="primary" label="Finalizar compra" />
          </q-item-label>
        </q-item-section>
      </q-item>

      <!-- products -->
      <q-card-section>
        <div
          v-for="(product, index) in order.products"
          :key="index"
          @mouseenter="hover = index"
          @mouseleave="hover = null"
          class="q-my-sm"
          :class="[
            hover === index ? 'shadow-transition shadow-10 ' : 'shadow-0',
          ]"
        >
          <div class="row q-pa-sm text-uppercase">
            <img
              :src="product.image"
              alt="imagem produto"
              height="100"
              class="q-pa-md"
            />

            <div class="column col-md-8">
              <div class="text-h6">
                {{ product.articleName }}
              </div>
              <div class="text-subtitle2">
                {{ product.articleDescription }}
              </div>
            </div>

            <div class="column col">
              <div class="text-subtitle2 text-primary">
                Preço Unitário: {{ $filters.priceBR(product.unitPrice) }}
              </div>
              <div class="text-subtitle2">
                Quantidade: {{ product.quantity }}
              </div>
              <div class="text-subtitle2 text-positive">
                total:
                {{ $filters.priceBR(product.quantity * product.unitPrice) }}
              </div>
            </div>
          </div>

          <q-card-actions align="center">
            <q-btn
              flat
              size="sm"
              color="negative"
              icon="close"
              label="Remover"
            />
          </q-card-actions>

          <q-separator spaced inset />
        </div>
      </q-card-section>
    </q-card>
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
