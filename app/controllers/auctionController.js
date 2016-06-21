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


});
