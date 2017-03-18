const root = 'api/admin/';

export default{
	get(uri, options = null){
		return new Promise((resolve, reject) => {
			Axios.get(root + uri, { params: options })
			.then((response) => {
		    resolve(response);
		  })
		  .catch((error) => {
		    reject(error.response);
		  });
		});
	},

	post(uri, data = null, options = null){
		return new Promise((resolve, reject) => {
			Axios.post(root + uri, data)
			.then((response) => {
		    resolve(response);
		  })
		  .catch((error) => {
		    reject(error.response);
		  });
		});
	},

	put(uri, data = null, options = null){
		return new Promise((resolve, reject) => {
			Axios.put(root + uri, data)
			.then((response) => {
		    resolve(response);
		  })
		  .catch((error) => {
		    reject(error.response);
		  });
		});
	},

	delete(uri, options = null){
		return new Promise((resolve, reject) => {
			Axios.delete(root + uri, { params: options })
			.then((response) => {
		    resolve(response);
		  })
		  .catch((error) => {
		    reject(error.response);
		  });
		});
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