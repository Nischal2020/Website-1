(function () {
    var mod = angular.module('components');

    mod.controller('eventsController', ['$scope', function ($scope) {
        // Should retrieve this form the API
        $scope.events = [
            {
                thumb : "assets/img/event1.jpg",
                title : "Event #1",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "assets/img/event2.jpg",
                title : "Event #2",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            }
        ];
    }]);
})();