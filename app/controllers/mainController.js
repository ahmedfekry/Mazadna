app.controller('MainController', ['$scope', '$rootScope','sessionService','$location','myService',function($scope, $rootScope,sessionService,$location,myService) {
    // $rootScope.text = "Fekry";
    $rootScope.logOut = function() {
        sessionService.destroy('uid');
        sessionService.destroy('username');
        sessionService.destroy('image');
        $location.path('/signIn');
    }

    $rootScope.islogged = function() {
    	// alert("fekry");
    	var connected = sessionService.get();
        return connected;
    }

    $rootScope.go = function(path) {
        // alert("fek");
        // alert(path);
        $location.path(path);
    }
    $rootScope.auctionId = 0;
    /* $rootScope.viewAuction= function (auction_id) {
    //     // body...
        var postObject = new Object();
        postObject.auction_id = auction_id;

        myService.post('auction.php/viewAuction',{
            temp : postObject
        }).then(function(results) {
    //         // body...

            if (results.status == 'success') {
                $location.path('/viewAuction'); 
                $rootScope.auction.description = results.auction.description;
                $rootScope.auction.start_time = results.auction.start_time;
                $rootScope.auction.end_time = results.auction.end_time;
                $rootScope.auction.start_price = results.auction.starting_price;
                $rootScope.auction.privacy = results.auction.privacy;
                $rootScope.auction.title = results.auction.title;
                $rootScope.auction.description = results.auction.description;
                $rootScope.auction.category_id = results.auction.category_id; 
                $rootScope.number_of_one_stars = results.number_of_one_stars; 
                $rootScope.number_of_two_stars = results.number_of_two_stars;
                $rootScope.number_of_three_stars = results.number_of_three_stars;
                $rootScope.number_of_four_stars = results.number_of_four_stars;
                $rootScope.number_of_five_stars = results.number_of_five_stars;
                var j=0
                for(;j<results.bid.length;j++){
                    $rootScope.auction.bid[j]=results.bid[j];
                }

                for(;j<results.bid.length;j++){
                    $rootScope.auction.ratings[j]=results.bid[j];
                }

            }

        });
    }*/

}]);