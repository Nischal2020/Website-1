(function () {
    var mod = angular.module('components');

    mod.controller('eventsController', ['$scope', '$resource', function ($scope, $resource) {
        // Should retrieve this form the API
         $resource('/api/v1/events').query(
            function(data) {
                $scope.events = data;
            }, function(error) {
                alert("Error: " + error.statusText + " (" + error.status + ")");
            }
        );
        /*$scope.events = [
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
        ];*/
    }]);
})();