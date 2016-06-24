var app = angular.module('mazadna', ['ngRoute'])

.config(function($routeProvider,$locationProvider) {
        $routeProvider

            // www.example.com/signUp

            // route for the signup page
            .when('/signUp', {
                templateUrl : 'app/partials/sign_up.html',
                controller  : 'authController'
            })

            // route for the home page
            .when('/home', {
                templateUrl : 'app/partials/home.html',
                controller  : 'homeController'
            })
            
            .when('/adminView', {
                templateUrl : 'app/partials/admin_view_auctions.html',
                controller  : 'admin_homeController'
            })

            .when('/viewAuction',{
                templateUrl : 'app/partials/viewAuction.html',
                controller : 'auctionController'
            })

            .when('/signIn',{
                templateUrl : 'app/partials/sign_in.html',
                controller : 'authController'
            })

            .when('/AdminSignIn',{
                templateUrl : 'app/partials/signInAdmin.html',
                controller : 'adminController'
            })

            .otherwise({
                redirectTo:'signIn'
            });

            // www.example.com/signIn

            // $locationProvider.html5Mode(true);
    });
