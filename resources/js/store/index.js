import Vue from 'vue';
import Vuex from 'vuex';
import auth from "./modules/auth";
import worktime from "./modules/worktime";
import createPersistedState from 'vuex-persistedstate'

/**
 * Register Vuex to Vue
 */
Vue.use(Vuex);

export default new Vuex.Store({

  /**
   * Variables saved in Vuex state
   */
  state: {
    errors: []
  },

  /**
   * Plugins used for Vuex
   */
  plugins: [createPersistedState()],

  /**
   * Getters for state
   */
  getters: {
    errors: state => state.errors
  },

  /**
   * Change state with mutations
   */
  mutations: {
    setErrors(state, errors) {
      state.errors = errors;
    }
  },

  /**
   * Initiate mutations through actions
   */
  actions: {},

  /**
   * Different modules used in Vuex
   */
  modules: {
    auth,
    worktime
  }
});
