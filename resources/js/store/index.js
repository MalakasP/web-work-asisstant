import Vue from 'vue';
import Vuex from 'vuex';
import auth from "./modules/auth";
import worktime from "./modules/worktime";
import createPersistedState from 'vuex-persistedstate'

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
      errors: []
    },

    plugins: [createPersistedState({
      storage: window.sessionStorage,
    })],
    
    getters: {
      errors: state => state.errors
    },
  
    mutations: {
      setErrors(state, errors) {
        state.errors = errors;
      }
    },
  
    actions: {},
  
    modules: {
      auth,
      worktime
    }    
});
