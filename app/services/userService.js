app.factory('myService', ['$http', function($http) {

    var urlBase = 'API/v1/';
    var myService = {};

    // user.php/signUp , admin.php/signIn
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
