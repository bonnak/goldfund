import Api from '../../api/ApiDeposit'
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
	RECEIVE_LANGUAGES (state, { body }) {
    state.pagination = new Pagination(body);
    body.data.forEach(p => {
      state.data.push(p);
    }); 
  },

  EDIT(state, { data }){
    state.data.find(el => el.id == data.id).status = data.status;
  },

  CLEAR_STORE (state){
    state.data.splice(0, state.data.length);
  }
}

const actions = {
	fetchData({ commit }, query = '', pagination = state.pagination){
		Api.fetchData({ 
      per_page : pagination.per_page,
      page     : pagination.current_page,
      query    : query
    }).then(
			(response) => {
        commit('CLEAR_STORE');
        commit('RECEIVE_LANGUAGES', { body: response.data });
      }
		);
	},

  approve({ commit }, data){
    Api.approve(data.id).then(
      (response) => {
        commit('EDIT', response);
      }
    );
  },

  sendMoney({ commit }, data){
    Api.sendMoney(data).then(
      (response) => {
        console.log(response);
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