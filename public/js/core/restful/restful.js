MetronicApp.constant("CSRF_TOKEN", '{{ csrf_token() }}');
MetronicApp.factory("Restful", [
 	'$http',
	'CSRF_TOKEN',
 	function ($http, CSRF_TOKEN) {
		 console.log(CSRF_TOKEN);
		var data = {'_token':CSRF_TOKEN};
        var obj = {};
        // start get 
        obj.get = function(url, params) {
            return $http({
        		url: url,
    			method: 'GET',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded'},
				// headers: {
				// 	'X-CSRF-TOKEN': CSRF_TOKEN,
				// 	'X-Requested-With': 'XMLHttpRequest'
				// },
				//cache : true,
    			//params: params,
				data: $.param(data)
            });
        };

		obj.save = function(url, params) {
			console.log(CSRF_TOKEN);
			return $http({
				url: url,
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': CSRF_TOKEN,
					'X-Requested-With': 'XMLHttpRequest'
				},
				data: params
			});
		};

        obj.put = function(url, params){
        	return $http({
        		url: url,
    			method: 'PUT',
				headers: { 'Content-Type' : 'application/x-www-form-urlencoded'},
				// headers: {
				// 	'X-CSRF-TOKEN': CSRF_TOKEN,
				// 	'X-Requested-With': 'XMLHttpRequest'
				// },
    			data: params
        	});
        };
        
        obj.patch = function(url, params){
        	return $http({
        		url: url,
    			method: 'PATCH',
				headers: {
					'X-CSRF-TOKEN': CSRF_TOKEN,
					'X-Requested-With': 'XMLHttpRequest'
				},
				data: $.param(data)
    			// data: params
        	});
        };
        
        obj.delete = function(url, params){
        	return $http({
        		url: url,
    			method: 'DELETE',
				headers: {
					'X-CSRF-TOKEN': CSRF_TOKEN,
					'X-Requested-With': 'XMLHttpRequest'
				},
    			data: params
        	});
        };

        return obj;
        
 	}
]);
