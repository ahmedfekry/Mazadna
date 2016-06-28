app.controller('admin_homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService,$window) {
    //initially set those objects to null to avoid undefined error
    $scope.fekry = "Fekry";
    $scope.init = function() {
        // $location.path('/viewCategory');
        var temp = new Object();
        temp.category_id = 0; 
        // $scope.fekry = "Fekry";
        myService.post('home.php/home',{
            temp: temp
        }).then(function (results) {
         var auctiondata = new Array(results.length);
         for(var i=0;i<results.length;i++){
          auctiondata[i]=new Array(8);
         }
         var j=0;
         for(;j<results.length;j++){
          auctiondata[j][0]=results[j].title;
          auctiondata[j][1]=results[j].id;
          auctiondata[j][2]=results[j].user_id;
          auctiondata[j][3]=results[j].start_time;
          auctiondata[j][4]=results[j].end_time;
          auctiondata[j][5]=results[j].privacy;
          auctiondata[j][6]=results[j].category_id;
          auctiondata[j][7]=results[j].starting_price;
          auctiondata[j][8]=results[j].active;

         }
         $scope.auction=auctiondata;
            
        });
    };
    $scope.numberOfUsers = 0;
    $scope.numberOfAuctions = 0;
    $scope.activeAuctions = 0;
    $scope.auctionPricesSum = 0;
    
    function users() {
      var temp = new Object();
      myService.post('admin.php/users',{
        temp : temp
      }).then(function(results) {
        if (results.usersNum) {
          $scope.numberOfUsers = results.usersNum;
        }
      });
    }

    function auctions() {
      var temp = new Object();
      myService.post('admin.php/auctions',{
        temp : temp
      }).then(function(results) {
        if (results.auctionsNum) {
          $scope.numberOfAuctions = results.auctionsNum;
        }
      });
    }

    function activeAuctions() {
      var temp = new Object();
      myService.post('admin.php/activeAuctions',{
        temp : temp
      }).then(function(results) {
        if (results.auctionsNum) {
          $scope.activeAuctions = results.auctionsNum;
        }
      });
    }

    function auctionPricesSum() {
      // alert("fekry");
      var temp = new Object();
      myService.post('admin.php/auctionPricesSum',{
        temp : temp
      }).then(function(results) {
        if (results.auctionsSum) {
          $scope.auctionPricesSum = results.auctionsSum;
        }
      });
    }

    $scope.adminStat = function () {
      users();
      auctions();
      activeAuctions();
      auctionPricesSum();
    }
    
    $scope.delete = function (auction_id) {
        var postObject = new Object();

        postObject.auction_id = auction_id;
        alert(auction_id);
        myService.post('auction.php/deleteAuction', {
            auction: postObject
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.message);
                $window.location.reload();
            }
        });
    }
});
