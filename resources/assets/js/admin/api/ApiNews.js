import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('news',  pagination);
  },

  update(model){
  	return Api.put('news', model);
  },

  create(model){
  	return Api.post('news', model);
  }
}