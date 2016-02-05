var app = angular.module('mazadna', ['ngRoute']);

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'app/partials/signIn.html',
        controller: 'authController'
      });
  }]);