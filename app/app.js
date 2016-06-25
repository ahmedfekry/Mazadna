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

            .when('/viewUserProfile',{
                templateUrl : 'app/partials/profile.html',
                controller : 'viewUserProfileController'
            })

            .otherwise({
                redirectTo:'signIn'
            });


            // www.example.com/signIn

           // $locationProvider.html5Mode(true);
    });
