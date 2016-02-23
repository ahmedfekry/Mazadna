app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
	$scope.auction={};
	
	$scope.auction = {
		owner:'',
		title:'',
		starting_price:'',
		privacy: '',
		end_date:'',
		description:''
	};

	$scope.create = function (auction) {
		var postObject = new Object();
		
		postObject.owner = $rootScope.user.uid;
		postObject.title = auction['title'];
		postObject.starting_price = auction['starting_price'];
		postObject.privacy = auction['privacy'];
		postObject.end_date = auction['end_date'];
		postObject.description = auction['description'];
		
		myService.post('create_auction',{
			auction: postObject
		}).then(function (results) {
			if (results.status == "success") {
				alert(results.message);
			};
		});
	}	

});