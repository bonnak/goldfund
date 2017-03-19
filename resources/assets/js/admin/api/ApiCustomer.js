import Api from './Api';

export default {
  fetchData(pagination) {
    return Api.get('customers',  pagination);
  },

  editEmail(data){
  	return Api.put('customer/email', data);
  },

  editBitCoinAddress(data){
  	return Api.put('customer/bitcoin/address', data);
  }
}