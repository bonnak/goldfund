import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('faq',  pagination);
  },

  update(model){
  	return Api.put('faq/update', model);
  },

  create(model){
  	return Api.post('faq', model);
  }
}