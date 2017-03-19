import Api from '../../api/ApiPlan'
import { Pagination } from '../../core/classes'

const state = {
	data: [],
  pagination: new Pagination()
}

const getters = {
	data: state => state.data,
	pagination: state => state.pagination
}

const mutations = {
	RECEIVE_DATA (state, { body }) {
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
	fetchData({ commit }, pagination = state.pagination){
		Api.fetchData({ 
      per_page : pagination.per_page,
      page     : pagination.current_page
    }).then(
			(response) => {
        commit('CLEAR_STORE');
        commit('RECEIVE_DATA', { body: response.data });
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