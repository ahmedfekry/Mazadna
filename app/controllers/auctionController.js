app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.initial = function() {
      
    };

    $scope.getdata = function(auction_id) {
        // $location.path('/viewCategory');
        var temp = new Object();
        temp.auction_id = auction_id; 
        // $scope.fekry = "Fekry";
        myService.post('viewAuction.php/viewAuction',{
            temp: temp
        }).then(function (results) {
         var auctiondata = new Array(results.length);

          auctiondata[0]=new Array(9);
         

         var j=0;
          auctiondata[j][0]=results[j].username;
          auctiondata[j][5]=results[j].massege;
          auctiondata[j][1]=results[j].item;
          auctiondata[j][2]=results[j].start_time;
          auctiondata[j][3]=results[j].duration;
          auctiondata[j][4]=results[j].success;
          auctiondata[j][6]=results[j].highest_bid_id;
          auctiondata[j][7]=results[j].highest_bider_id;
          auctiondata[j][8]=results[j].category_name;

         $scope.auction=auctiondata;
            
    	});
    };


    $scope._auction = {};
    $scope._auction = {
        user_id:1,
        title:'',
        starting_price:'',
        privacy:'',
        start_time:'',
        end_time:'',
        description:'',
        on_site:1,
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


        postObject.user_id = _auction['user_id'];
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
