var app = angular.module('mazadna', ['ngRoute'])

.config(function($routeProvider,$locationProvider) {
        $routeProvider

            // www.example.com/signUp

            // route for the signup page
            .when('/signUp', {
                templateUrl : 'app/partials/sign_up2.html',
                controller  : 'authController',
                isSignUp : true
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
                templateUrl : 'app/partials/auction_item.html',
                controller : 'auctionController'
            })

            .when('/signIn',{
                templateUrl : 'app/partials/sign_in.html',
                controller : 'authController',
                isLogin: true

            })

            .when('/AdminSignIn',{
                templateUrl : 'app/partials/signInAdmin.html',
                controller : 'adminController',
                isAdminSignIn : true
            })

            .when('/createAuction',{
                templateUrl : 'app/partials/create_auction.html',
                controller : 'auctionController'
            })

            .when('/editAccount',{
                templateUrl : 'app/partials/editAccount.html',
                controller : 'userController'
            })
            
            .otherwise({
                redirectTo:'signIn'
            });

            // www.example.com/signIn

            // $locationProvider.html5Mode(true);
    });
 

app.run(function($rootScope,$location) {
    // var routespermissions = ['/home']; //routes that require login
    $rootScope.$on('$routeChangeStart',function(event,next) {
        // alert($rootScope.islogged());
        var userAutho = false;
        // alert("fekry");
        var connected = $rootScope.islogged();
            connected.then(function(msg) {
                if(!msg.data.uid && !next.isLogin){
                    // alert('11'+msg.data.uid);
                    if (next.isSignUp) {
                        $location.path("/signUp");
                    }else if (next.isAdminSignIn){
                        $location.path("/AdminSignIn");
                    }else{
                        $location.path("/signIn");
                    }
                    userAutho = true;
                }else if(msg.data.uid && next.isLogin){
                    $location.path("/home")
                }
            });
    });
});
