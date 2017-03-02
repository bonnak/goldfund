import Api from '../../api/ApiCustomer'
import { Pagination } from '../../core/classes'

const state = {
	data: [],
  pagination: {}
}

const getters = {
	data: state => state.data,
	pagination: state => state.pagination
}

const mutations = {
	RECEIVE_LANGUAGES (state, { body }) {
    state.pagination = new Pagination(body);
    body.data.forEach(p => {
      state.data.push(p);
    }); 
  },

  CLEAR_STORE (state){
    state.data.splice(0, state.data.length);
  }
}

const actions = {
	fetchData({ commit }, pagination = null){
		Api.fetchData(pagination).then(
			(response) => {
        commit('CLEAR_STORE');
        commit('RECEIVE_LANGUAGES', { body: response.data });
      }
		);
	}
}

export default {
	namespaced: true,
  state,
  getters,
  actions,
  mutations
}