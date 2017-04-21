import Api from '../../api/ApiNews'
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

  update({ commit }, model){
    return new Promise((resolve, reject) => {
      Api.update(model).then((response) =>{
        resolve(response);
      },(err_response) => {
        reject(err_response);
      });
    });    
  },

  create({ commit }, model){
    return new Promise((resolve, reject) => {
      Api.create(model).then((response) =>{
        resolve(response);
      },(err_response) => {
        reject(err_response);
      });
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