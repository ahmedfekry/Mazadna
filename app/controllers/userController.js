app.controller('userController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    
    $scope.user = {
        first_name:'',
        last_name:'',
        user_name:'',
        email:'',
        new_password:'',
        phone_number:''
    };

    $scope.init = function(user_id) {
        var postObject = new Object();
        postObject.user_id = user_id;
        myService.post('user.php/getUser',{
            user: postObject
        }).then(function(results) {
            if (results.status == "success") {
                $scope.user.first_name = results.user.first_name;
                $scope.user.last_name = results.user.last_name;
                $scope.user.user_name = results.user.user_name;
                $scope.user.email = results.user.email;
                $scope.user.phone_number = results.user.phone_number;
            }
        });
    };

    $scope.editAccount = function(user) {
        var postObject = new Object();
        
        postObject.first_name = user['first_name'];
        postObject.last_name = user['last_name'];
        postObject.user_name = user['user_name'];
        postObject.email = user['email'];
        postObject.new_password = user['new_password'];
        postObject.old_password = user['old_password'];
        postObject.phone_number = user['phone_number'];

        myService.post('user.php/updateUser',{
            user: postObject
        }).then(function(results) {
            if (results.status == "success") {
                alert(results.message);
                $route.reload();
            }else{
                alert(results.message)
            }
        });  
    };

    
});
