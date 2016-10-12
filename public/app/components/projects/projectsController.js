(function () {
    var mod = angular.module('components');

    mod.controller('projectsController', ['$scope', function ($scope) {
        // Should retrieve this form the API
        $scope.projects = [
            {
                thumb : "assets/img/project1.jpg",
                title : "Project #1",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "assets/img/project2.jpg",
                title : "Project #2",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "assets/img/project3.jpg",
                title : "Project #3",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            }
        ];
    }]);
})();