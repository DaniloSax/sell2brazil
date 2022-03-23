/*
export function someAction (context) {
}
*/

import { api } from "src/boot/axios";

export async function index({ commit }) {
  const { data } = await api.get('orders')

  commit('INIT_STATE', data.orders)

  console.log('orders', data)
}

export async function addCart({ commit, state }, product) {

  // const order = state.orders.find(order => !order.finished)
  // const prod = { product, order_id: order?.order_id || null }
  const { data } = await api.post('orders', product)
  console.log('action addCard', data)
}
