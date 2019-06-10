import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    isLoggedin: false,
    isLoggedFormShown: false
  },
  mutations: {
    isLoggedin (state) {
      state.isLoggedin = true
    },
    isLoggedout (state) {
      state.isLoggedin = false
    },
    setLoggedFormShown (state,value) {
      state.isLoggedFormShown = value
    },
  },
  getters: {
    isLoggedin: state => state.isLoggedin,
  }
})
