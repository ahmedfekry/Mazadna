app.controller('auctionController', function ($scope, $rootScope, $routeParams, $location, $http, myService) {
    //initially set those objects to null to avoid undefined error
    $scope.auction = {};
// $user_id = $header->auction->user_id;
//         $description = $header->auction->description;
//         $title = $header->auction->title;
//         $starting_price = $header->auction->starting_price;
//         $privacy = $header->auction->privacy;
//         $end_time = $header->auction->end_time;
//         // echo $end_time;
//         $on_site = $header->auction->on_site;
//         $category_id = $header->auction->category_id;

    // jQuery('#endDate').datetimepicker({
    //     onSelect: function(dateText, inst) {
    //       $("input[name='endDate']").val(dateText);
    //     }
    // });

    $scope.auction = {
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
    
    $scope.fekry="fekryas";
    $scope.create = function (auction) {
        var postObject = new Object();
        if (auction['end_time'] == '') {
            auction['end_time'] = $("#endDate").val();
        }

        if (auction['start_time'] == '') {
            auction['start_time'] = $("#startDate").val();
        }


        postObject.user_id = auction['user_id'];
        postObject.title = auction['title'];
        postObject.starting_price = auction['starting_price'];
        postObject.privacy = auction['privacy'];
        postObject.start_time = auction['start_time'];
        postObject.end_time = auction['end_time'];
        postObject.description = auction['description'];
        postObject.category_id =parseInt(auction['category_id']);
        

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