app.controller('homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.init = function() {
    	var temp = new Object();
    	myService.post('home.php/home',{
            temp: temp
        }).then(function (results) {
            for(var i = 0; i < results.length; i++) {
                if (results[i].status == 'success') {
                     alert('true');
                     // $location.path('/sign_in');
                      $scope.auction = {
                        name:results[i].username,
                        item:results[i].item,
                        start_time:results[i].start_time,
                        duration:results[i].duration,
                        privacy:results[i].privacy,
                        onsite:results[i].onsite
                      };
            }
            else
                 alert(results[0].status);
            }
    		
    	});
    };


});
