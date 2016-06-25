 app.controller('homeController', ['$scope','$rootScope','$routeParams','$location', '$http', 'myService' ,
 	function ($scope,$rootScope, $routeParams, $location, $http, myService) {
 	$scope.obj={};
 	
 	
 	
    $scope.viewProfile = function(obj)
    {
    	var postObject = new Object();
    	postObject.id = obj['id'];
        

    	myService.post('user.php/viewUserProfile',
        {
    		user: postObject
    	}).then(function(results)
        {
    		if(results.userStatus == "success")
    		{
    			
    			$scope.userInfo.userStatus = results.userStatus;
			    $scope.userInfo.auctionStatus = results.auctionStatus;

			    $scope.userInfo.id = results.userInfo.id;
			    $scope.userInfo.username = results.userInfo.username;

			    $scope.userInfo.email = results.userInfo.email;
			    $scope.userInfo.phoneNumber = results.userInfo.phoneNumber;
			    $scope.userInfo.firstName = results.userInfo.firstName;
			    $scope.userInfo.lastName = results.userInfo.lastName;
			    $scope.userInfo.image = results.userInfo.image;
			    $scope.userInfo.commuliteveStars = results.userInfo.commuliteveStars;
			    var j = 0;
                for(; j < results.auctions.length ; j++)
                {
                    $scope.userInfo.auctions[j] = results.auctions[j];
                }
                $location.path('/viewUserProfile');
			    
    		}
    	});
    };
}]);
