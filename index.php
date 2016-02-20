<!DOCTYPE html>
<html ng-app="mazadna">
	<head>
		<title>Mazadna</title>
		<script src = "assets/js/jquery.min.js"></script>
		<script src = "http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		
 		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- <base href="/signIn"> -->
	</head>
	<body >

		<div ng-view></div> 
		
		<div ng-controller="MainController"></div>
		<!-- include all the library here -->
		<script src="assets/js/angular.min.js"></script>
		<script src="assets/js/angular-route.min.js"></script>
		<script src="assets/js/angular-animate.min.js" ></script>

		<!-- include the JavaScript files here -->
		<script type="text/javascript" src="app/app.js"></script>
		
		<script type="text/javascript" src="app/services/userService.js"></script>
		<!-- Controllers -->
		<script type="text/javascript" src="app/controllers/mainController.js"></script>
		<script type="text/javascript" src="app/controllers/authController.js"></script>
		<script type="text/javascript" src="app/controllers/homeController.js"></script>
		
		<!-- Directives -->
		<script type="text/javascript" src="app/directives/mainDirective.js"></script>
		
		<!-- Services -->
	</body>
</html>