app.controller('homeController', ['$scope','$rootScope', function ($scope,$rootScope) {
   $scope.st = $rootScope.islogged();
}]);
