app.controller('MainController', ['$scope', '$rootScope',function($scope, $rootScope) {
          $rootScope.message = "Hello";
          $rootScope.userInfo = {
	 		userStatus: '',
	 		auctionStatus: '',
	 		id: 0,
	 		username: '',
	 		email: '',
	 		phoneNumber: '',
	 		firstName: '',
	 		lastName: '',
	 		image: '',
	 		commuliteveStars: '',
	 		auctions: []
	 	};
}]);