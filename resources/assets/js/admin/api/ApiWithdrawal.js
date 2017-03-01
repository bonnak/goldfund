import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('withdrawal',  pagination);
  },

  approve(data) {
    return Api.post('withdrawal/approve',  data);
  }
}