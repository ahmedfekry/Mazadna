app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    
    $scope._auction = {};
    $scope._auction = {
        user_id:0,
        title:'',
        starting_price:'',
        privacy:'',
        start_time:'',
        end_time:'',
        description:'',
        category_id:0
    };

    $scope.auction={};
    $scope.bid={};
    $scope.ratings={};
    $scope.names={};
    $scope.description="";
    $scope.price=0.0;
    
   $scope.submit_bid = function (auctionId,price) {
        
        var postObject = new Object();
        alert(auctionId);
        postObject.user_id = localStorage.getItem('uid');
        postObject.auction_id = auctionId;
        postObject.price = price;
        alert(price);
        myService.post('auction.php/submitBid', {
            user: postObject
        }).then(function (results) {

            if (results.status == "success") {
                $location.path('/viewAuction');
            }
            alert(results.message);

        });

    };

   $scope.submitRating = function (description,auctionId) {
        
        var postObject = new Object();
        alert(auctionId);

        postObject.user_id = localStorage.getItem('uid');
        postObject.auction_id = auctionId;
        postObject.description = description;
        postObject.stars = parseInt($('input[name=rating]:checked', '.form').val());

        myService.post('auction.php/submitAuctionRating', {
            auction: postObject
        }).then(function (results) {

            if (results.status == "success") {
                alert(results.message);
                $location.path('/viewAuction');
            }

        });

    };

    $scope.viewAuction2= function (auction_id) {
    // body...
        var postObject = new Object();
        postObject.auction_id = auction_id;

        myService.post('auction.php/viewAuction',{
            temp : postObject
        }).then(function(results) {
    // body...

            if (results.status == 'success') {
                $location.path('/viewAuction'); 
                $scope.auction.description = results.auction.description;
                $scope.auction.start_time = results.auction.start_time;
                $scope.auction.end_time = results.auction.end_time;
                $scope.auction.start_price = results.auction.starting_price;
                $scope.auction.privacy = results.auction.privacy;
                $scope.auction.title = results.auction.title;
                $scope.auction.category_id = results.auction.category_id; 
                $scope.number_of_one_stars = results.number_of_one_stars; 
                $scope.number_of_two_stars = results.number_of_two_stars;
                $scope.number_of_three_stars = results.number_of_three_stars;
                $scope.number_of_four_stars = results.number_of_four_stars;
                $scope.number_of_five_stars = results.number_of_five_stars;
                var j=0;

                for(;j<results.bid.length;j++){
                    $scope.bid[j]=results.bid[j];
                }
                var i=0;
                for(;i<results.ratings.length;i++){
                    $scope.ratings[i]=results.ratings[i];
                }
                
                    $scope.names=results.userNames;

            }

        });
    };
    // $scope.fekry="fekryas";
    $scope.create = function (_auction) {
        var postObject = new Object();
        if (_auction['end_time'] == '') {
            _auction['end_time'] = $("#endDate").val();
        }

        if (_auction['start_time'] == '') {
            _auction['start_time'] = $("#startDate").val();
        }


        postObject.user_id = localStorage.getItem('uid');
        postObject.title = _auction['title'];
        postObject.starting_price = _auction['starting_price'];
        postObject.privacy = _auction['privacy'];
        postObject.start_time = _auction['start_time'];
        postObject.end_time = _auction['end_time'];
        postObject.description = _auction['description'];
        postObject.category_id =parseInt(_auction['category_id']);
        

        myService.post('auction.php/createAuction', {
            auction: postObject
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.message);
                $location.path('/home');
            }else{
                alert(results.message);
                // $location.path('/home');
            }
        });
    };

    $scope.delete = function (auction) {
        var postObject = new Object();

        postObject.auction_id = auction['id'];
        myService.post('auction.php/deleteAuction', {
            auction: postObject
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.message);
                $location.path('/home');
            }
        });
    };
});
