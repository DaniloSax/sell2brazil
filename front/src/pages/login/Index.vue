<template>
  <q-page padding>
    <div class="row justify-center items-center" style="height: 100vh">
      <q-card style="width: 80%">
        <q-card-section class="row">
          <q-btn
            color="primary"
            icon="keyboard_arrow_left"
            label="Voltar"
            :to="{ name: 'home' }"
            flat
            size="md"
          />
          <Logotype />
        </q-card-section>
        <q-card-section>
          <div>
            <q-input v-model="user.email" type="email" label="Email" />
            <q-input v-model="user.password" type="password" label="Senha" />
          </div>
        </q-card-section>
        <q-card-actions class="row justify-center">
          <q-btn color="primary" label="Entrar" size="md" />
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import { reactive } from "@vue/reactivity";
import Logotype from "../../components/Logotype.vue";
export default {
  setup(props) {
    const user = reactive({});
    return { user };
  },
  components: { Logotype },
};
</script>

<style>
</style>
