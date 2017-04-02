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

  CLEAR_DATA (state){
      state.data.splice(0, state.data.length);
  },

  RESET_PAGINATION (state){
      state.pagination = new Pagination();
  },
}

const actions = {
	fetchData({ commit, state }, param = { pagination: state.pagination, query: '' }){
    Api.fetchData({ 
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