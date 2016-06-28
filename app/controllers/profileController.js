app.controller('profileController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
$scope.userInfo = {};
$scope.userInfo.auctions = {};
$scope.viewProfile = function()
    {
      var postObject = new Object();
      postObject.id = localStorage.getItem('uid');
        

      myService.post('user.php/viewUserProfile',
        {
        user: postObject
      }).then(function(results)
        {
        if(results.userStatus == "success")
        {
          // alert("fek");
          $scope.userInfo.userStatus = results.userStatus;
          $scope.userInfo.auctionStatus = results.auctionStatus;

          $scope.userInfo.id = results.userInfo.id;
          $scope.userInfo.username = results.userInfo.username;

          $scope.userInfo.email = results.userInfo.email;
          $scope.userInfo.phoneNumber = results.userInfo.phoneNumber;
          $scope.userInfo.firstName = results.userInfo.firstName;
          // alert($scope.userInfo.firstName);
          $scope.userInfo.lastName = results.userInfo.lastName;
          // $scope.userInfo.image = results.userInfo.image;
          $scope.userInfo.commuliteveStars = results.userInfo.commuliteveStars;
          
          var j = 0;

                for(; j < results.auctions.length ; j++)
                {
                    $scope.userInfo.auctions[j] = results.auctions[j];
                }
            //    $location.path('/viewUserProfile');
          if (results.userInfo.id == localStorage.getItem('uid')) {
            $("#followww").hide();
            $("#folowww2").hide();
          }else{
            var postObject = new Object();
            postObject.id1 = results.userInfo.id;
            postObject.id2 = localStorage.getItem('uid');
        

            myService.post('user.php/viewUserProfile',{
              user: postObject
              }).then(function(results) {
                $("#followww").hide();
              });
          }
        }
      });
    };

    $scope.follow = function(user_id) {
      // body...
    }

});