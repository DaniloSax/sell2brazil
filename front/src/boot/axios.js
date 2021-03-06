import { boot } from 'quasar/wrappers'
import axios from 'axios'

// Be careful when using SSR for cross-request state pollution
// due to creating a Singleton instance here;
// If any client changes this (global) instance, it might be a
// good idea to move this instance creation inside of the
// "export default () => {}" function below (which runs individually
// for each client)
const api = axios.create({ baseURL: 'http://localhost:8000/api/' })
const api1 = axios.create({ baseURL: 'http://localhost:9001/' })
const api2 = axios.create({ baseURL: 'http://localhost:9002/' })
const api3 = axios.create({ baseURL: 'http://localhost:9003/' })

// api1.interceptors.request.use(function (config) {
//   config.headers['Access-Control-Allow-Origin'] = '*'
// }, function (error) {

//   return Promise.reject(error)

// })

api.interceptors.request.use(function (config) {

  const token = localStorage.getItem(localStorage.key(0))

  if (token) {

    config.headers = { Authorization: `Bearer ${token}` }

  }

  return config
}, function (error) {

  return Promise.reject(error)

});


api.interceptors.response.use(function (response) {
  return response
}, function (error) {

  if (error.response.status === 422) {
    return Promise.reject(error.response.data)
  }

  if (error.response.status === 405) {

    localStorage.removeItem(localStorage.key(0))

  }

  return error
});

export default boot(({ app }) => {
  // for use inside Vue files (Options API) through this.$axios and this.$api

  app.config.globalProperties.$axios = axios
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  app.config.globalProperties.$api = api
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
})

export { api, api1, api2, api3 }
