'user strict';

app.factory('sessionService', ['$http', function($http) {
	return{
		set:function(key , value) {
			// body...
			return sessionStorage.setItem(key,value);
		},
		get:function() {
			// body...
			var connected = $http.get('API/v1/user.php/session');
			return connected;
		},
		destroy:function(key) {
			// body...
			$http.get('API/v1/user.php/logout');
			return sessionStorage.removeItem(key);
		}

	};
    
}]);
