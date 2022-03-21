/*
export function someAction (context) {
}
*/

import { api } from "src/boot/axios"

export async function login({ commit }, user) {

  const { data } = await api.post('login', user)

  localStorage.setItem(data.token.accessToken.name, data.token.plainTextToken)
}
