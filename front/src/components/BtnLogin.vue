<template>
  <div>
    <q-btn-dropdown flat v-if="auth" color="primary" :label="auth.name">
      <q-list>
        <q-item clickable v-close-popup :to="{ name: 'requests' }">
          <q-item-section>
            <q-icon color="primary" name="inventory_2" size="sm" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Meus pedidos</q-item-label>
          </q-item-section>
        </q-item>

        <q-item clickable v-close-popup v-ripple @click="logout">
          <q-item-section>
            <q-icon color="primary" name="logout" size="sm" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Sair</q-item-label>
          </q-item-section>
        </q-item>
      </q-list>
    </q-btn-dropdown>

    <q-btn v-else flat color="primary" label="Entrar" :to="{ name: 'login' }" />
  </div>
</template>

<script>
import { computed, onMounted, ref } from "@vue/runtime-core";
import { api } from "../boot/axios";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default {
  setup(props) {
    const auth = computed(() => store.getters["auth/auth"]);

    const router = useRouter();
    const store = useStore();

    async function hasToken() {
      const token = localStorage.getItem(localStorage.key(0));

      if (token) {
        const { data } = await api.get("auth");
        store.commit("auth/UPDATE_AUTH", data.auth);

        return true;
      } else return false;
    }

    async function logout() {
      await api.post("logout");
      localStorage.removeItem(localStorage.key(0));

      store.commit("auth/UPDATE_AUTH", null);
      store.commit("cart/INIT_STATE", []);

      router.replace({ name: "home" });
    }

    onMounted(() => {
      hasToken();
    });

    return { auth, logout };
  },
};
</script>

<style>
</style>
