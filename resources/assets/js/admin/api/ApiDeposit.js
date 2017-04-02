import Api from './Api';

export default {
  fetchData(params) {
    return Api.get('deposit',  params);
  },

  approve(data){
  	return Api.post('deposit/approve', data);
  }
}