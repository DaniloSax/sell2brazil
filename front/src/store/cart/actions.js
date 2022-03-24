/*
export function someAction (context) {
}
*/

import { api } from "src/boot/axios";

export async function index({ commit }) {
  const { data } = await api.get("orders");

  commit("INIT_STATE", data.orders);

  return data.orders;
}

export async function addCart({ commit, getters, dispatch }, product) {
  await api.post("orders", product);
  const { data } = await api.get("orders");

  commit("INIT_STATE", data.orders);

  // if (getters.getOrders.length) {
  // commit("ADD_CART", product);
  // }

  await dispatch("index");
}

export async function finishedOrder({ dispatch }, order) {
  await api.put(`orders/${order.order_id}`);
}

export async function cancelCart({ dispatch }, order) {
  await api.delete(`orders/${order.order_id}`);
}
