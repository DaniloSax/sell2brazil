/*
export function someAction (context) {
}
*/

import { api } from "src/boot/axios";

export async function index({ commit }) {
  const { data } = await api.get('orders')

  commit('INIT_STATE', data.orders)
}

export async function addCart({ commit, state, dispatch }, product) {

  console.log('carregando orders',state.orders)
  if (!state.orders.length) {
    console.log('carregando orders')
    await dispatch('index')
  }

  const { data } = await api.post('orders', product)
  commit('ADD_CART', product)
  console.log('action addCard', data)
}
