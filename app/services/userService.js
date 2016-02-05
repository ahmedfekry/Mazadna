app.factory("Data", ['$http', 'toaster',
    function ($http, toaster) { // This service connects to our REST API

        var serviceBase = 'api/v1/index.php';

        obj.get = function (q) {
            return $http.get(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        obj.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };

        obj.put = function (q, object) {
            return $http.put(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };

        obj.delete = function (q) {
            return $http.delete(serviceBase + q).then(function (results) {
                return results.data;
            });
        };

        return obj;
}]);