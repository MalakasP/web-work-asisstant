import Vue from 'vue';
import router from './router';
import store from './store';
import VueSimpleAlert from "vue-simple-alert";

import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import ExampleComponent from './components/ExampleComponent.vue';

require('./bootstrap');

Vue.use(VueSimpleAlert);

const app = new Vue({
    el: '#app',
    components: {
      HeaderComponent,
      FooterComponent,
      ExampleComponent
    },
    router,
    store
});


