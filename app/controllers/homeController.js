app.controller('homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.initial = function() {
        $('#category').hide();
    };
    $scope.userImage = localStorage.getItem('image');
    $scope.userName= localStorage.getItem('username');
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
          auctiondata[i]=new Array(4);
         }
         var j=0;
         for(;j<results.length;j++){
          auctiondata[j][0]=results[j].id;
          auctiondata[j][1]=results[j].title;
          auctiondata[j][2]=results[j].description;
          auctiondata[j][3]=results[j].image;
         }

         $scope.auction=auctiondata;
    	});
    };

     $scope.viewAuction= function (auction_id) {
    //     // body...
        $rootScope.auctionId = auction_id;
        $location.path('/viewAuction');
    };

    $scope.join = function (id){
        var postObject = new Object();
        postObject.auctionID = id;
        postObject.userID = localStorage.getItem('uid');

        // alert(id + " " + localStorage.getItem('uid'));

        myService.post('home.php/join',{
        postObject:postObject
        }).then(function (results) {
            if (results.status == "success") {
                alert(results.message);
            }
            else
                 alert(results.message);
        });
    }   


});