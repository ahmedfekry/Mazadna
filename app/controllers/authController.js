app.controller('authController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};
    $scope.signup = {};
    
    $scope.signup = {
        first_name:'',
        last_name:'',
        username:'',
        email:'',
        password:'',
        phone_number:''
    };

    $scope.signUp = function (user) {
        var postObject = new Object();
        
        postObject.first_name = user['first_name'];
        postObject.last_name = user['last_name'];
        postObject.username = user['username'];
        postObject.email = user['email'];
        postObject.password = user['password'];
        postObject.phone_number = user['phone_number'];

        myService.post('signUp', {
            user: postObject
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.message);
                $location.path('/home');
            }
        });
    };

    $scope.login = {
        username:'',
        password:''
    };
    $scope.signIn = function (user) {
        var postObject = new Object();
        postObject.username = user['username'];
        postObject.password = user['password'];

        myService.post('signIn',{
            user: postObject
        }).then(function (results) {
            if (results.status == "success") {
                $location.path('/home')
            }
        });
    }

});