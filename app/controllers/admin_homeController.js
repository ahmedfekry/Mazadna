app.controller('admin_homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
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
	});