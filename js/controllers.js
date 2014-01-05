'use strict';

var gaslog = angular.module('gaslog', ['filters']);

gaslog.controller('LogEntries', function($scope, $http) {
  $http.get('gaslog.json').success(function(data) {
		$scope.fillups = data;
  });
  $scope.orderProp = 'date';
});

angular.module('filters', []).
filter('gasprice', function ($filter) {
  return function (input) {
    return '$' + $filter('number')(input, 3);
  };
});
