<template>
  <q-page padding>
    <q-table
      title="Produtos"
      :rows="rows"
      :columns="columns"
      :rows-per-page-options="rowsPerPageOptions"
      grid
    >
      <template v-slot:item="{ row }">
        <div class="q-pa-xs col-xs-12 col-sm-6 col-md-4">
          <q-card class="my-card">
            <q-card-section>
              {{ row }}
            </q-card-section>
            <q-card-section>
              Lorem ipsum dolor sit amet, consectetur adipiscing elit
            </q-card-section>
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
    const pagination = ref({
      page: 1,
      rowsPerPage: getItemsPerPage(),
    });
    const rows = ref([]);

    onMounted(() => productsIndex());

    async function productsIndex() {
      const { products } = await store.dispatch("product/index");

      rows.value = products;

      console.log("products component", products);
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
      return $q.screen.gt.xs ? ($q.screen.gt.sm ? [3, 6, 9] : [3, 6]) : [3];
    });

    return { columns, rows, pagination, rowsPerPageOptions };
  },
};
</script>

<style>
</style>
