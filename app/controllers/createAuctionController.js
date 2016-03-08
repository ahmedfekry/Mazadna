app.controller('createAuctionController' ,['$scope','$rootScope','$routeParams','$location','$http','sessionService','myService',
	function($scope,$rootScope, $routeParams, $location, $http,sessionService,myService){
		$scope.auction ={
			id : sessionService.get('user'),
			duration : '',
			price : '',
			privacy : ''
		};

		$scope.submitAuction = function(auction){
			var auctionObj = new Object();
			auctionObj.userID = auction["id"];
			auctionObj.duration = auction["duration"];
			auctionObj.price = auction["price"];
			auctionObj.privacy = auction["privacy"];
			myService.post('createAuction',{
					auction: auctionObj
				}).then( function(results){
					alert(results.message);
					if(results.status == "success"){
						$location.path("/home")
					}
				});
			}
		};
	}]);