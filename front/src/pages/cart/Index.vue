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
          <q-item-label> COD: {{ order.order_code }} </q-item-label>
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
            TOTAL COM DESCONTO:
            {{
              $filters.priceBR(
                order.total_amount_wihtout_discount -
                  order.total_amount_with_discount
              )
            }}
          </q-item-label>
        </q-item-section>

        <q-item-section>
          <q-item-label>
            <q-btn
              :color="order.finished ? 'warning' : 'primary'"
              :icon="order.finished ? 'check' : ''"
              :label="order.finished ? 'compra finalizada' : 'Finalizar compra'"
              :disabled="order.finished ? true : false"
              @click="finishedOrder(order)"
            />
          </q-item-label>
        </q-item-section>

        <q-item-section>
          <q-item-label>
            <q-btn
              color="negative"
              icon="close"
              label="Cancelar"
              :disabled="order.finished ? true : false"
              @click="cancelCart(order)"
            />
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
          <div class="row q-pa-sm">
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

            <q-separator v-if="$q.platform.is.desktop" spaced inset vertical />

            <div
              class="column items-center col text-uppercase"
              :class="{ 'q-ml-sm justify-center': $q.platform.is.desktop }"
            >
              <div class="text-subtitle2 text-primary">
                Preço Unitário: {{ $filters.priceBR(product.unitPrice) }}
              </div>
              <div class="text-subtitle2">
                Quantidade: {{ product.quantityBought }}
              </div>
              <div class="text-subtitle2 text-positive">
                total:
                {{
                  $filters.priceBR(product.quantityBought * product.unitPrice)
                }}
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
              @click="detacheProduct(product, order)"
            />
          </q-card-actions>

          <q-separator spaced inset />
        </div>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import { onMounted, ref } from "@vue/runtime-core";
import { useStore } from "vuex";
import { useQuasar } from "quasar";
import { api } from "src/boot/axios";

export default {
  setup(props) {
    const hover = ref(null);
    const store = useStore();
    const orders = ref([]);
    const loading = ref(false);
    const $q = useQuasar();

    onMounted(async () => {
      loading.value = true;
      orders.value = await (await api.get("orders")).data.orders;
      loading.value = false;
    });

    async function finishedOrder(order) {
      $q.loading.show({
        delay: 400,
      });

      await store.dispatch("cart/finishedOrder", order);
      await store.dispatch("cart/index");
      order.finished = true;
      $q.notify({ message: "Compra finalizada!", color: "positive" });
      $q.loading.hide();
    }

    async function cancelCart(order) {
      $q.loading.show({
        delay: 400,
      });

      await store.dispatch("cart/cancelCart", order);
      await store.dispatch("cart/index");
      orders.value.splice(orders.value.indexOf(order), 1);

      $q.notify({ message: "Compra cancelada!", color: "positive" });
      $q.loading.hide();
    }

    async function detacheProduct(product) {
      await api.post(`detache-product/${product.id}`);
      orders.value = await (await api.get("orders")).data.orders;
      await store.dispatch("cart/index");
    }

    return {
      orders,
      hover,
      finishedOrder,
      loading,
      cancelCart,
      detacheProduct,
    };
  },
};
</script>

<style>
</style>
