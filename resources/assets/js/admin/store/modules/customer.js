import Api from '../../api/ApiCustomer'
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
	fetchData({ commit, state }, pagination = state.pagination){
		Api.fetchData({ 
      per_page : pagination.per_page,
      page     : pagination.current_page
    }).then(
			(response) => {
        commit('CLEAR_STORE');
        commit('RECEIVE_DATA', { body: response.data });
      }
		);
	},

  editEmail({ commit }, data){ 
    return new Promise((resolve, reject) => {
        Api.editEmail({
          id: data.id,
          email: data.email
        }).then(
          (response) => {           
            resolve(response);
          },

          (err_response) => {
            reject(err_response);
          }
        );
    });
  },

  editBitCoinAddress({ commit }, data){
    return new Promise((resolve, reject) => {
        Api.editBitCoinAddress({
          id: data.id,
          bitcoin_account: data.bitcoin_account
        }).then(
          (response) => {
            resolve(response);
          },

          (err_response) => {
            reject(err_response);
          }
        );
    });
  }
}

export default {
	namespaced: true,
  state,
  getters,
  actions,
  mutations
}