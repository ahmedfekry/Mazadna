app.controller('homeController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.init = function() {
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
                      /*{
                        name:results[i].username,
                        item:results[i].item,
                        start_time:results[i].start_time,
                        duration:results[i].duration,
                        privacy:results[i].privacy,
                        onsite:results[i].onsite
                      };*/
                    	
        });

    };
      $scope.signIn = function (user){

        
      }
   
});
/*
 $auction = array('id'=>$id,
        'username'=>$name,
        'item' => $item_name,
        'start_time' => $row['start_time'],
        'duration' => $row['duration'],
        'status' => "success",
        'massege'=>"this is auction",
        'highest_bid_id'=>$row['highest_bid_id'],
        'highest_bider_id'=>$row['highest_bider_id'],
        'category_id'=>$row['category_id'],
        'onsite'=>$onsite,
        'privacy'=>$private); */