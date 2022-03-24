/*
export function someAction (context) {
}
*/

import { api, api1, api2, api3 } from "src/boot/axios";

export async function index({ commit, getters }) {
  const token = localStorage.getItem(localStorage.key(0))

  if (token) {
    const { data } = await api.get("orders");

    // await updateOthersServers(data.orders[0])

    commit("INIT_STATE", data.orders);


    return data.orders;
  }

  return []

}

export async function addCart({ commit, dispatch }, product) {
  await api.post("orders", product);
  const { data } = await api.get("orders");

  commit("INIT_STATE", data.orders);

  await dispatch("index");
}

export async function finishedOrder({ dispatch }, order) {
  await api.put(`orders/${order.order_id}`);
}

export async function cancelCart({ dispatch }, order) {
  await api.delete(`orders/${order.order_id}`);
}

async function updateOthersServers(order) {
  const server1 = {
    OrderId: order.order_id,
    OrderCode: order.order_code,
    OrderDate: order.order_date,
    TotalAmountWihtoutDiscount: order.total_amount_wihtout_discount,
    TotalAmountWithDiscount: order.total_amount_with_discount
  }
  const server2 = {
    id: order.order_id,
    code: order.order_code,
    date: order.order_date,
    total: order.total_amount_wihtout_discount,
    discount: order.total_amount_with_discount
  }
  const server3 = {
    id: order.order_id,
    code: order.order_code,
    date: order.order_date,
    totalAmount: order.total_amount_wihtout_discount,
    totalAmountWithDiscount: order.total_amount_with_discount
  }

  await api1.post('order', server1)
  await api2.post('v1/order', server2)
  await api3.post('web_api/order', server3)
}
