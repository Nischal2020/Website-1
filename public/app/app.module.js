(function() {
    var app = angular.module('cpApp', ['cpAppRoutes']);

    // Controller that's applied to the body tag
    app.controller('mainController', [ '$scope', '$location', function ($scope,$location) {

        //Show/hide main image based on the location
        $scope.$on('$locationChangeStart', function(event) {
            $scope.showHomeImage = $location.path() === '/';
        });

    }]);
})();