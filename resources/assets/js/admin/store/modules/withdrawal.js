import Api from '../../api/ApiWithdrawal'
import { Pagination } from '../../core/classes'

const state = {
	data: [],
  pagination: new Pagination()
}

const getters = {
	pending: state => state.data.filter(item => item.status == 0),
  approved: state => state.data.filter(item => item.status == 1),
  canceled: state => state.data.filter(item => item.status == 2 || item.status == 3),
	pagination: state => state.pagination
}

const mutations = {
	RECEIVE_DATA (state, { body }) {
    state.pagination = new Pagination(body);
    body.data.forEach(p => {
      state.data.push(p);
    }); 
  },

  EDIT(state, { data }){
    state.data.find(el => el.id == data.id).status = data.status;
  },

  CLEAR_DATA (state){
      state.data.splice(0, state.data.length);
  },

  RESET_PAGINATION (state){
      state.pagination = new Pagination();
  },
}

const actions = {
	getPending({ commit }, pagination = state.pagination, query = ''){
    Api.getPending({ 
      per_page : pagination.per_page,
      page     : pagination.current_page,
      query    : query
    }).then(
      (response) => {
        commit('CLEAR_DATA');
        commit('RECEIVE_DATA', { body: response.data });
      }
    );
  },

  getApproved({ commit }, pagination = state.pagination, query = ''){
    Api.getApproved({ 
      per_page : pagination.per_page,
      page     : pagination.current_page,
      query    : query
    }).then(
      (response) => {
        commit('CLEAR_DATA');
        commit('RECEIVE_DATA', { body: response.data });
      }
    );
  },

  getCanceled({ commit }, pagination = state.pagination, query = ''){
		Api.getCanceled({ 
      per_page : pagination.per_page,
      page     : pagination.current_page,
      query    : query
    }).then(
			(response) => {
        commit('CLEAR_DATA');
        commit('RECEIVE_DATA', { body: response.data });
      }
		);
	},

  approve({ commit }, data){
    Api.approve(data).then(
      (response) => {
        commit('EDIT', response);
      }
    );
  },

  cancel({ commit }, data){
    Api.cancel(data).then(
      (response) => {
        commit('EDIT', response);
      }
    );
  },

  clearStore({ commit }){
    commit('CLEAR_DATA');
    commit('RESET_PAGINATION');
  }
}

export default {
	namespaced: true,
  state,
  getters,
  actions,
  mutations
}