var app = angular.module('mazadna', ['ngRoute']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'app/partials/signUp.html',
        controller: 'authController'
      })
      .when('/dashboard', {
                title: 'Dashboard',
                templateUrl: 'app/partials/dashboard.html',
                controller: 'authController'
		 });
  }]);