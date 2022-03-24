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
            <q-input
              v-model="user.email"
              label="Email"
              :error="!!errors.email"
              bottom-slots
            >
              <template v-slot:error>
                {{ errors?.email }}
              </template>
            </q-input>

            <q-input
              v-model="user.password"
              :error="!!errors.password"
              bottom-slots
              type="password"
              label="Senha"
            >
              <template v-slot:error>
                {{ errors?.password }}
              </template>
            </q-input>
          </div>
        </q-card-section>
        <q-card-actions class="row justify-center">
          <q-btn
            color="primary"
            label="Entrar"
            size="md"
            @click="login"
            :loading="loading"
          />
        </q-card-actions>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import { reactive, ref } from "@vue/reactivity";
import Logotype from "../../components/Logotype.vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import { useQuasar } from "quasar";

export default {
  components: { Logotype },

  setup(props) {
    const user = ref({
      email: "danilovsdanilo@gmail.com",
      password: "danilo123",
    });

    const errors = ref({});
    const loading = ref(false);

    const store = useStore();
    const router = useRouter();

    const $q = useQuasar();

    async function login() {
      loading.value = true;
      try {
        await store.dispatch("login/login", user.value);

        router.push({ name: "home" });
      } catch (error) {
        $q.notify({
          message: error.message,
          color: "negative",
        });

        errors.value = prepareErrors(error.errors);
      } finally {
        loading.value = false;
      }
    }

    function prepareErrors(errors) {
      let obj = {};

      if (errors.email) {
        obj.email = errors.email[0];
      }
      if (errors.password) {
        obj.password = errors.password[0];
      }

      return obj;
    }

    return { user, login, errors, loading };
  },
};
</script>

<style>
</style>
