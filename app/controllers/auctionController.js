app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
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
