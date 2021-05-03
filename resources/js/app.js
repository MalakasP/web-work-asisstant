import Vue from "vue";
import store from "./store";
import router from "./router";
import VueSimpleAlert from "vue-simple-alert";
import Notifications from 'vue-notification'
import AppComponent from './components/home/AppComponent.vue';
import VCalendar from 'v-calendar';

require('./bootstrap');

Vue.use(VueSimpleAlert);
Vue.use(Notifications);
Vue.use(VCalendar);


Vue.config.productionTip = false;

axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response.status >= 402 && error.response.status < 500) {
      store.commit("setErrors", error.response.data.errors);
    } else if (error.response.status === 401) {
      store.commit("auth/setUserData", null);
      store.commit("auth/setAuthToken", null);
      localStorage.removeItem("authToken");
      router.push({ name: "Login" });
    }
    return Promise.reject(error);
  }
);

axios.interceptors.request.use( function(config) {
  config.headers.common = {
    Authorization: `Bearer ${store.getters["auth/token"]}`,
    "Content-Type": "application/json",
    Accept: "application/json"
  };

  return config;
});

Vue.directive('tooltip', function(el, binding){
  $(el).tooltip({
           title: binding.value,
           placement: binding.arg,
           trigger: 'hover'             
       })
})

const app = new Vue({
    el: '#app',
    components: {
        AppComponent,
    },
    router,
    store,
    
});


