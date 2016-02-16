app.factory('myService', ['$http', function($http) {

    var urlBase = '/API/v1/user.php';
    var myService = {};

    myService.post = function (q, object) {
            return $http.post(serviceBase + q, object).then(function (results) {
                return results.data;
            });
        };

    return myService;
}]);

// app.factory("userService", ['$http',
//     function ($http, toaster) { // This service connects to our REST API

//         var serviceBase = 'API/v1/test.php/';

//         var obj = {};
//         obj.get = function (q) {
//             return $http.get(serviceBase + q).then(function (results) {
//                 return results.data;
//             });
//         };

//         obj.post = function (q, object) {
//             return $http.post(serviceBase + q, object).then(function (results) {
//                 return results.data;
//             });
//         };
//         obj.put = function (q, object) {
//             return $http.put(serviceBase + q, object).then(function (results) {
//                 return results.data;
//             });
//         };
//         obj.delete = function (q) {
//             return $http.delete(serviceBase + q).then(function (results) {
//                 return results.data;
//             });
//         };

//         obj.toast = function (data) {
//             toaster.pop(data.status, "", data.message, 10000, 'trustedHtml');
//         }
//         return obj;
// }]);