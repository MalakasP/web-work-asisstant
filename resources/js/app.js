import Vue from "vue";
import router from "./router";
import store from "./store";
import VueSimpleAlert from "vue-simple-alert";
import AppComponent from './components/AppComponent.vue';

require('./bootstrap');

Vue.use(VueSimpleAlert);

Vue.config.productionTip = false;

axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response.status === 422) {
      store.commit("setErrors", error.response.data.errors);
    } else if (error.response.status === 401) {
      store.commit("auth/setUserData", null);
      localStorage.removeItem("authToken");
      router.push({ name: "Login" });
    } else {
      return Promise.reject(error);
    }
  }
);

axios.interceptors.request.use( function(config) {
  config.headers.common = {
    Authorization: `Bearer ${localStorage.getItem("authToken")}`,
    "Content-Type": "application/json",
    Accept: "application/json"
  };

  return config;
});

const app = new Vue({
    el: '#app',
    components: {
        AppComponent
    },
    router,
    store
});


