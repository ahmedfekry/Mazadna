 app.controller('authController', ['myService', function (myService) {
  // Do something with myService
}]);

// // app.controller('authController', ['$scope', '$rootScope', '$routeParams', '$location', '$http', 'userService',function($scope, $rootScope, $routeParams, $location, $http, Data) {
// 	$scope.login = {};
//     $scope.signup = {};
   
//     $scope.signup = {
//         first_name:'',
//         last_name:'',
//         username:'',
//         email:'',
//         phone_number:'',
//         password:'',
//     };
    
//     $scope.signUp = function (customer) {
//         alert(customer.first_name)
//         userService.post('signUp', {
//             customer: customer
//         }).then(function (results) {
//             if (results.status == "success") {
//                 alert(results.uid);
//             }
//         });
//     };

//     // $scope.doLogin = function (customer) {
//     //     Data.post('login', {
//     //         customer: customer
//     //     }).then(function (results) {
//     //         Data.toast(results);
//     //         if (results.status == "success") {
//     //             $location.path('dashboard');
//     //         }
//     //     });
//     // };
//     // $scope.logout = function () {
//     //     Data.get('logout').then(function (results) {
//     //         Data.toast(results);
//     //         $location.path('login');
//     //     });
//     // }
// }]);