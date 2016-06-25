<!DOCTYPE html>
<html ng-app="mazadna">
	<head>

	    <meta charset="UTF-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

	    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css">
	    
	    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
	    <link rel="stylesheet" href="assets/css/styles.css">
	    <link rel="stylesheet" href="assets/css/img_style.css">

		<title>Mazadna</title>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script type="text/javascript" src="assets/js/jquery.form.js"></script>
		<!-- Latest compiled and minified JavaScript -->
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

 		Latest compiled and minified CSS
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> -->

		<!-- <base href="/signIn"> -->
		<script type="text/javascript">
			$(document).ready(function(){
				$('#images').on('change',function(){
					$('#multiple_upload_form').ajaxForm({
						target:'#images_preview',
						beforeSubmit:function(e){
							$('.uploading').show();
						},
						success:function(e){
							$('.uploading').hide();
						},
						error:function(e){
						}
					}).submit();
				});
			});
		</script>
	</head>
	<body >





		<div ng-view></div>

		<div ng-controller="MainController"></div>
		<!-- <script src="assets/js/jquery-2.1.4.min.js"></script> -->
      	<script src="assets/js/bootstrap.min.js"></script>
      	<script src="assets/js/script.js"></script>
		
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>


		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.4.0/lang/en-gb.js"></script> 

		<script src="assets/js/script.js"></script>

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
		<script type="text/javascript" src="app/controllers/adminController.js"></script>
		<script type="text/javascript" src="app/controllers/auctionController.js"></script>
		<script type="text/javascript" src="app/controllers/admin_homeController.js"></script>

		<!-- Directives -->
		<script type="text/javascript" src="app/directives/mainDirective.js"></script>

		<!-- Services -->
	</body>
</html>
