(function () {
    var mod = angular.module('components');

    mod.controller('eventsController', ['$scope', function ($scope) {
        // Should retrieve this form the API
        $scope.events = [
            {
                thumb : "http://i.istockimg.com/file_thumbview_approve/97860153/3/stock-photo-97860153-business-man-hand-working-on-laptop-computer-with-digital-layer.jpg",
                title : "Event #1",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            },
            {
                thumb : "http://i.istockimg.com/file_thumbview_approve/97889747/3/stock-photo-97889747-let-s-get-started-word-on-white-ring-binder-notebook.jpg",
                title : "Event #2",
                subtitle : "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit"
            }
        ];
    }]);
})();