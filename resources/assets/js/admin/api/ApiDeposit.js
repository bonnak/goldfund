import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('deposit/history',  pagination);
  },

  approve(data){
  	return Api.post('deposit/approve', data);
  }
}