'use strict';

var juruApp = angular.module('juruApp', []);

juruApp.controller('ExperienceListController', function ($scope, $http){
	console.log('in');
	$http.get('http://gradually.alexeves.co.uk/app_dev.php/api/graduates/25/cvs/6/experiences.json').success(function(data){
		$scope.experiences = data;
	});

	console.dir($scope.experiences);
});