import Api from '../../api/ApiDeposit'
import { Pagination } from '../../core/classes'

const state = {
	data: [],
  pagination: new Pagination(),
}

const getters = {
	pending: state => state.data.filter(item => item.status == 0),
  approved: state => state.data.filter(item => item.status == 1),
  canceled: state => state.data.filter(item => item.status == 2),
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
	fetchPending({ commit, state }, param = { pagination: state.pagination, query: '' }){
		Api.fetchData({ 
      status   : 0,
      per_page : param.pagination.per_page,
      page     : param.pagination.current_page,
      query    : param.query
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