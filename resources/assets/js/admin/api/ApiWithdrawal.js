import Api from './Api';

export default {
  getPending(pagination) {
    return Api.get('withdrawal/pending',  pagination);
  },

  approve(data) {
    return Api.post('withdrawal/approve',  data);
  },

  cancel(data) {
    return Api.post('withdrawal/cancel',  data);
  },

  getApproved(pagination) {
    return Api.get('withdrawal/approved',  pagination);
  },

  getCanceled(pagination) {
    return Api.get('withdrawal/canceled',  pagination);
  }
}