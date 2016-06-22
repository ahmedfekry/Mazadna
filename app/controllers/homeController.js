app.controller('homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.init = function() {
    	$('#category').hide();
        var temp = new Object();
    	myService.post('home.php/home',{
            temp: temp
        }).then(function (results) {
            var auctionData  = new Array(results.length);
           for (var i = 0; i < results.length; i++) {
              auctionData[i] = new Array(3);
            }
            var j =0;
            //$scope.auction = results;
            //alert($auction);
                for(j = 0; j < results.length; j++) {
                    auctionData[j][0] = results[j].username;
                    auctionData[j][1] = results[j].massege;
                    auctionData[j][2] = results[j].id;
                }
                
                $scope.auction = auctionData;
                    	
        });

    };

    $scope.getdata = function(category_id) {
        // $location.path('/viewCategory');
        var temp = new Object();
        temp.category_id = category_id; 
        // $scope.fekry = "Fekry";
        myService.post('home.php/home',{
            temp: temp
        }).then(function (results) {
         var auctiondata = new Array(results.length);
         for(var i=0;i<results.length;i++){
          auctiondata[i]=new Array(2);
         }
         var j=0;
         for(;j<results.length;j++){
          auctiondata[j][0]=results[j].username;
          auctiondata[j][1]=results[j].massege;
         }

         $scope.auction=auctiondata;
            
        });
    };
   
});
