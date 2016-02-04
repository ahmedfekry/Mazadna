app.directive('main',function () {
	return {
		restrict: 'E', 
		scope : {
			main: '='
		},
		templateUrl: 'main.html'
	}
});
//restrict specifies how the directive will be used in the view. 
// The 'E' means it will be used as a new HTML element.

// scope specifies that we will pass information into this 
// directive through an attribute named info.
// The = tells the directive to look for an attribute named main
// in the <app-info> element, like this:
// <app-main info="shutterbugg"></app-main>
// The data in info becomes available to use in the template given by templateURL.

// templateUrl specifies the HTML to use in order to display the data in scope.info. 
// Here we use the HTML in js/directives/appInfo.html.