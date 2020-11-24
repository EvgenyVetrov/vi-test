import Vue from 'vue'
import axios from 'axios'
import './config.js'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify';

Vue.prototype.$axios = axios.create({baseURL: process.env.VUE_APP_APIDOMAIN});



Vue.config.productionTip = false

new Vue({
  router,
  vuetify,
  axios,
  render: h => h(App)
}).$mount('#app')