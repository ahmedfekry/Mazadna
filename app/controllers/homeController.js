 app.controller('homeController', ['$scope','$rootScope','$routeParams','$location', '$http', 'myService' ,
 	function ($scope,$rootScope, $routeParams, $location, $http, myService) {
 	$scope.obj={};
 	$scope.userInfo={};
 	
 	$scope.userInfo = {
 		user_status: '',
 		auction_status: '',
 		id: 0,
 		username: '',
 		email: '',
 		phone_number: '',
 		first_name: '',
 		last_name: '',
 		image: '',
 		commuliteve_stars: '',
 		auctions: []
 	};

    $scope.viewProfile = function(obj)
    {
    	var postObject = new Object();
    	postObject.id = obj['id'];
        alert("aa");

    	myService.post('user.php/viewUserProfile',
        {
    		user: postObject
    	}).then(function(results)
        {
    		alert(results.user_status);
    		if(results.user_status == "success")
    		{
    			alert(results.message);
    			$scope.user_status = results.user_status;
			    $scope.auction_status = results.auction_status;
			    $scope.userInfo.id = results.userInfo.id;
			    $scope.userInfo.username = results.userInfo.username;
			    $scope.userInfo.email = results.userInfo.email;
			    $scope.userInfo.phone_number = results.userInfo.phone_number;
			    $scope.userInfo.first_name = results.userInfo.first_name;
			    $scope.userInfo.last_name = results.userInfo.last_name;
			    $scope.userInfo.image = results.userInfo.image;
			    $scope.commuliteve_stars = results.userInfo.commuliteve_stars;
			    $scope.auctions = $results.auctions;

			    $location.path('/viewUserProfile');
    		}
    	});
    };
}]);
