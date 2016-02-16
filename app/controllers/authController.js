 app.controller('authController', ['myService','$scope', function (myService,$scope) {
  // Do something with myService
		$scope.login = {};
 	   	$scope.signup = {};
	    $scope.signup = {
	        first_name:'',
	        last_name:'',
	        username:'',
	        email:'',
	        phone_number:'',
	        password:'',
	    };
    $scope.signUp = function (customer) {
        alert(customer.first_name)
        myService.post('signUp', {
            customer: customer
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.uid);
            }
        });
    };

}]);

// // app.controller('authController', ['$scope', '$rootScope', '$routeParams', '$location', '$http', 'userService',function($scope, $rootScope, $routeParams, $location, $http, Data) {
   
    

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