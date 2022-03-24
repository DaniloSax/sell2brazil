<template>
  <q-page padding>
    <div class="text-overline text-uppercase">Meus pedidos</div>

    <q-separator class="q-mb-lg" />

    <q-card class="my-card">
      <q-card-section>
        <q-list
          padding
          class="rounded-borders"
          v-for="purchase in purchases"
          :key="purchase.id"
        >
          <!-- {{ purchase }} -->
          <q-expansion-item dense dense-toggle expand-separator>
            <template v-slot:header>
              <q-item-section avatar>
                <q-avatar icon="inventory_2" color="primary" text-color="white" />
              </q-item-section>

              <q-item-section>
                <q-item-label> COD: {{ purchase.order_code }} </q-item-label>
              </q-item-section>

              <q-item-section>
                <q-item-label> Data: {{ purchase.order_date }} </q-item-label>
              </q-item-section>

              <q-item-section>
                <q-item-label>
                  TOTAL SEM DESCONTO:
                  {{ $filters.priceBR(purchase.total_amount_wihtout_discount) }}
                </q-item-label>
              </q-item-section>

              <q-item-section>
                <q-item-label class="text-negative">
                  VALOR DESCONTADO:
                  {{ $filters.priceBR(purchase.total_amount_with_discount) }}
                </q-item-label>
              </q-item-section>

              <q-item-section>
                <q-item-label class="text-positive">
                  VALOR PAGO:
                  {{
                    $filters.priceBR(
                      purchase.total_amount_wihtout_discount -
                        purchase.total_amount_with_discount
                    )
                  }}
                </q-item-label>
              </q-item-section>
            </template>

            <q-card>
              <q-card-section>
                <q-card-section>
                  <div
                    v-for="(product, index) in purchase.products"
                    :key="index"
                    @mouseenter="hover = index + product.id"
                    @mouseleave="hover = null"
                    class="q-my-sm"
                    :class="[
                      hover === index + product.id
                        ? 'shadow-transition shadow-10 '
                        : 'shadow-0',
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

                      <q-separator
                        v-if="$q.platform.is.desktop"
                        spaced
                        inset
                        vertical
                      />

                      <div
                        class="column items-center col text-uppercase"
                        :class="{
                          'q-ml-sm justify-center': $q.platform.is.desktop,
                        }"
                      >
                        <div class="text-subtitle2 text-primary">
                          Preço Unitário:
                          {{ $filters.priceBR(product.unitPrice) }}
                        </div>
                        <div class="text-subtitle2">
                          Quantidade: {{ product.quantityBought }}
                        </div>
                        <div class="text-subtitle2 text-positive">
                          total:
                          {{
                            $filters.priceBR(
                              product.quantityBought * product.unitPrice
                            )
                          }}
                        </div>
                      </div>
                    </div>
                  </div>
                </q-card-section>
              </q-card-section>
            </q-card>
          </q-expansion-item>
        </q-list>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { api } from "../../boot/axios";
export default {
  setup() {
    const purchases = ref([]);
    const hover = ref(null);

    onMounted(async () => {
      const { data } = await api.get("purchases");
      purchases.value = data.purchases;
    });

    function total(total_amount_wihtout_discount, total_amount_with_discount) {
      return total_amount_wihtout_discount - total_amount_with_discount;
    }

    return { purchases, hover, total };
  },
};
</script>

<style>
</style>
