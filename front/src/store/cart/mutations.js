/*
export function someMutation (state) {
}
*/

export function INIT_STATE(state, orders) {
  state.orders = orders
}

export function ADD_CART(state, product) {
  state.orders.find(o => !o.finished).products.push(product)
}
