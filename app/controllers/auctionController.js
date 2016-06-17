app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    
    $scope.create = function (auction) {
        var postObject = new Object();

        postObject.title = auction['title'];
        postObject.title = auction['title'];
        postObject.title = auction['title'];
        postObject.title = auction['title'];
        postObject.title = auction['title'];
        

        myService.post('auction.php/createAuction', {
            user: postObject
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