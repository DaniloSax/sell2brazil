<template>
  <q-page padding>
    <div class="text-overline">PRODUTOS IMPERDÍVEIS</div>
    <q-separator class="q-mb-lg" />

    <q-table
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="rowsPerPageOptions"
      :loading="loading"
      grid
    >
      <template v-slot:item="{ row, rowIndex }">
        <div
          class="q-pa-xs col-xs-12 col-sm-6 col-md-4 col-lg-3"
          :key="rowIndex"
        >
          <q-card
            @mouseenter="hover = rowIndex"
            @mouseleave="hover = null"
            class="fit"
            :class="[hover === rowIndex ? 'shadow-transition shadow-10 ' : '']"
          >
            <span class="q-ma-sm text-overline">COD-{{ row.articleCode }}</span>

            <q-card-section>
              <div class="flex flex-center">
                <img :src="row.image" alt="imagem produto" height="135" />
              </div>
            </q-card-section>

            <q-responsive :ratio="16 / 9">
              <q-card-section>
                <p class="text-h6">
                  {{ row.articleName }}
                </p>

                <p>
                  {{ $filters.priceBR(row.unitPrice) }}
                </p>

                <p class="text-subtitle2">
                  {{ row.articleDescription }}
                </p>

                <p>Quantidade: {{ row.quantity }}</p>
              </q-card-section>
            </q-responsive>

            <q-card-actions class="items-center justify-between">
              <q-btn
                color="primary"
                label="Adicionar ao carrinho"
                style="width: 80%"
                @click="addCart(row)"
                :loading="row.loading"
              />
              <q-btn flat round icon="favorite_border" />
            </q-card-actions>
          </q-card>
        </div>
      </template>
    </q-table>
  </q-page>
</template>

<script>
import { computed, onMounted, ref, watch } from "@vue/runtime-core";
import { useStore } from "vuex";
import { useQuasar } from "quasar";
import { useRouter } from "vue-router";

const columns = [
  {
    name: "name",
    required: true,
    label: "Nome",
    align: "left",
    field: "articleName",
    sortable: true,
  },

  {
    name: "preco",
    required: true,
    label: "Preço",
    align: "left",
    field: "unitPrice",
    sortable: true,
  },

  {
    name: "quantity",
    required: true,
    label: "Quantidade",
    align: "left",
    field: "quantity",
    sortable: true,
  },
];

export default {
  name: "Products",

  setup(props) {
    const $q = useQuasar();
    const store = useStore();
    const router = useRouter();
    const pagination = ref({
      page: 1,
      rowsPerPage: getItemsPerPage(),
    });
    const rows = ref([]);
    const hover = ref(0);
    const loading = ref(true);
    const auth = computed(() => store.getters["auth/auth"]);

    onMounted(async () => {
      await productsIndex();

      if (auth.value) {
        await store.dispatch("cart/index");
      }

      loading.value = false;
    });

    async function productsIndex() {
      const { products } = await store.dispatch("product/index");

      rows.value = products;
    }

    async function addCart(product) {
      if (auth.value) {
        product.loading = true;
        await store.dispatch("cart/addCart", product);
        product.loading = false;
      } else {
        router.push({ name: "login" });
      }
    }

    function getItemsPerPage() {
      if ($q.screen.lt.sm) {
        return 3;
      }
      if ($q.screen.lt.md) {
        return 6;
      }
      return 9;
    }

    watch(
      () => $q.screen.name,
      () => {
        pagination.value.rowsPerPage = getItemsPerPage();
      }
    );

    const rowsPerPageOptions = computed(() => {
      return $q.screen.gt.xs ? ($q.screen.gt.sm ? [4, 6, 9] : [3, 6]) : [3];
    });

    return {
      columns,
      rows,
      pagination,
      rowsPerPageOptions,
      hover,
      loading,
      addCart,
    };
  },
};
</script>

<style>
.altura {
  max-height: 16vh;
}
</style>
