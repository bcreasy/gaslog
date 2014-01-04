'use strict';

var gaslog = angular.module('gaslog', []);

gaslog.controller('LogEntries', function($scope, $http) {
  $http.get('gaslog.json').success(function(data) {
		$scope.fillups = data;
  });
  $scope.orderProp = 'date';
});
