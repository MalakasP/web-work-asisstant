import Vue from 'vue';
import Vuex from 'vuex';

import storeData from "./auth";

Vue.use(Vuex);

const store = new Vuex.Store(storeData);

export default{
    store
}