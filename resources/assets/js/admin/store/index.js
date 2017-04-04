import Vue from 'vue'
import Vuex from 'vuex'
import * as actions from './actions'
import * as getters from './getters'
import user from './modules/user'
import customer from './modules/customer'
import deposit from './modules/deposit'
import plan from './modules/plan'
import withdrawal from './modules/withdrawal'
import faq from './modules/faq'

Vue.use(Vuex)

export default new Vuex.Store({
  actions,
  getters,
  modules: {
  	user,
    customer,
    deposit,
    plan,
    withdrawal,
    faq
  }
})
