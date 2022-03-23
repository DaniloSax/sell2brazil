import { boot } from "quasar/wrappers";

export default boot(({ app }) => {
  app.config.globalProperties.$filters = {
    priceBR(price) {
      return Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }).format(price);
    },
  };
});
