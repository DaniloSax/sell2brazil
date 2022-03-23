/*
export function someGetter (state) {
}
*/

export const getOrders = state => state.orders
export const getOrder = state => state.orders.find(o => !o.finished)
