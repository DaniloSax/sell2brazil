/*
export function someAction (context) {
}
*/

import { api } from "src/boot/axios";


export async function index() {
  const { data } = await api.get('products')

  console.log(data)
}
