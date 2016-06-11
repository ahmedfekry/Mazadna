app.controller('adminController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.login = {};

    $scope.login = {
        username:'',
        password:''
    };
    $scope.signIn = function (user) {
        var postObject = new Object();
        postObject.username = user['username'];
        postObject.password = user['password'];

        myService.post('admin.php/signInAdmin',{
            user: postObject
        }).then(function (results) {
            if (results.status == "success") {
                $location.path('/home')
            }
        });
    }

});
