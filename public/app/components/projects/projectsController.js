(function () {
    var mod = angular.module('components');

    mod.controller('projectsController', ['$scope', function ($scope) {
        // Should retrieve this form the API
        $scope.projects = [
            {
                thumb : "http://i4.istockimg.com/file_thumbview_approve/83967207/5/stock-photo-83967207-hud-hologram-futuristic-colorful-abstract-background.jpg",
                title : "Project #1",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "http://i3.istockimg.com/file_thumbview_approve/76611677/5/stock-photo-76611677-abstract-background-science-technology.jpg",
                title : "Project #2",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "http://i2.istockimg.com/file_thumbview_approve/75447797/5/stock-photo-75447797-optical-fiber-abstract.jpg",
                title : "Project #3",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            }
        ];
    }]);
})();