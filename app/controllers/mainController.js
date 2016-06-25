app.controller('MainController', ['$scope', '$rootScope','sessionService','$location','myService',function($scope, $rootScope,sessionService,$location,myService) {
    // $rootScope.text = "Fekry";
    $rootScope.logOut = function() {
        sessionService.destroy('uid');
        $location.path('/signIn');
    }

    $rootScope.islogged = function() {
    	// alert("fekry");
    	var connected = sessionService.get();
        return connected;
    }

}]);