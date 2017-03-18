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