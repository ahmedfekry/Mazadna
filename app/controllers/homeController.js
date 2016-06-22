
app.controller('homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.initial = function() {
        $('#category').hide();
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
