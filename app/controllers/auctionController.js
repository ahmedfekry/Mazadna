app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.initial = function() {
      
    };
    $scope.auction = {};
    $scope.viewAuction= function (auction_id) {
        // body...
        var postObject = new Object();
        postObject.auction_id = auction_id;

        myService.post('auction.php/viewAuction',{
            temp : postObject
        }).then(function(results) {
            // body...
            if (results.status == 'success') {
                $scope.auction.description = results.auction.description;
                $scope.auction.start_time = results.auction.start_time;
                $scope.auction.end_time = results.auction.end_time;
                $scope.auction.privacy = results.auction.privacy;
                $scope.auction.title = results.auction.title;
                $scope.auction.description = results.auction.description;
                $scope.auction.category_id = results.auction.category_id;
                $scope.auction. = results.auction.description;
                

            }
        });
    }
// [auction] => Array
//         (
//             [id] => 1
//             [user_id] => 1
//             [description] => fekry
//             [start_time] => 2016-06-17 00:40:00
//             [end_time] => 2016-06-25 01:01:00
//             [privacy] => Private
//             [title] => AhmedAuction
//             [category_id] => 1
//             [starting_price] => 4
//             [active] => 1
//             [highest_bid_id] => 
//             [highest_bider_id] => 
//         )

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
    
    // $scope.fekry="fekryas";
    $scope.create = function (_auction) {
        var postObject = new Object();
        if (_auction['end_time'] == '') {
            _auction['end_time'] = $("#endDate").val();
        }

        if (_auction['start_time'] == '') {
            _auction['start_time'] = $("#startDate").val();
        }


        postObject.user_id = sessionStorage.getItem('uid');
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
