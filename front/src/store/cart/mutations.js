/*
export function someMutation (state) {
}
*/

export function INIT_STATE(state, orders) {
  state.orders = orders;
}

export function ADD_CART(state, product) {
  state.orders.find((o) => !o.finished).products.push(product);
}

export function FINISHED_ORDER(state, order) {
  state.orders.find((o) => o.order_id === order.order_id).finished = true;
}
