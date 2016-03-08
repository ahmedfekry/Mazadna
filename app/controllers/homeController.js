 app.controller('homeController',['$scope' , '$location' , '$rootScope' , '$routeParams', function ($scope , $location ,  $rootScope, $routeParams) {
    $scope.createAuction = function(){
    	$location.path('/createAuction');
    }
}]);
