import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('deposit/history',  pagination);
  },

  approve(id){
  	return Api.post('deposit/' + id + '/approve');
  }
}