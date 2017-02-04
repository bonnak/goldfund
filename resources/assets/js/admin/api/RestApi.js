const root = 'api/admin/';

export default{
	get(uri, options = null){
		return Axios.get(root + uri);
	},

	post(uri, data = null, options = null){
		return Axios.post(root + uri, data);
	},

	put(uri, data = null, options = null){
		return Axios.put(root + uri, data);
	},

	delete(uri, options = null){
		return Axios.delete(root + uri);
	}
}

const merge = (target) => {
  for (let i = 1, j = arguments.length; i < j; i++) {
    let source = arguments[i] || {};
    for (let prop in source) {
      if (source.hasOwnProperty(prop)) {
        let value = source[prop];
        if (value !== undefined) {
          target[prop] = value;
        }
      }
    }
  }

  return target;
}