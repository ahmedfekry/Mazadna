app.factory('myService', ['$http', function($http) {

    var urlBase = 'API/v1/user.php/';
    var myService = {};

    // signUp, signIn
    myService.post = function (q, object) {
            return $http.post(urlBase + q, object).then(function (results) {
                return results.data;
            });
        };

    myService.get = function (q) {
    	// body...
    	return $http.post(urlBase + q).then(function(results){
    		return results.data;
    	});
    };
    return myService;
}]);
