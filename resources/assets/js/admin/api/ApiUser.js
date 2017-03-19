import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('users',  pagination);
  }
}