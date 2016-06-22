var app = angular.module('mazadna', ['ngRoute'])

.config(function($routeProvider,$locationProvider) {
        $routeProvider

            // www.example.com/signUp

            // route for the home page
            .when('/signUp', {
                templateUrl : 'app/partials/sign_up.html',
                controller  : 'authController'
            })

            // route for the about page
            .when('/home', {
                templateUrl : 'app/partials/home.html',
                controller  : 'homeController'
            })

            .when('/signIn',{
                templateUrl : 'app/partials/sign_in.html',
                controller : 'authController'
            })

            .when('/AdminSignIn',{
                templateUrl : 'app/partials/signInAdmin.html',
                controller : 'adminController'
            })

            .when('/createAuction',{
                templateUrl : 'app/partials/create_auction.html',
                controller : 'auctionController'
            })

            .otherwise({
                redirectTo:'signIn'
            });

            // www.example.com/signIn

            // $locationProvider.html5Mode(true);
    });


app.run(function($rootScope,$location) {
    var routespermissions=['/home']; //routes that require login
    $rootScope.$on('$locationChangeStart',function() {
        // alert($rootScope.islogged());
        if (routespermissions.indexOf($location.path()) != 1) {
            var connected = $rootScope.islogged();
            connected.then(function(msg) {
                // body...
                if(!msg.data.uid){
                    $location.path('/signIn');
                }
            });
        }
    });
});
