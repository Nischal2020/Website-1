(function() {
    //Declares the directive module
    angular.module('directives', []);

    //Declares the components module
    angular.module('components', []);

    //Creates our main module - app modelu
    var app = angular.module('cpApp', ['cpAppRoutes', 'directives', 'components']);

    // Controller that's applied to the body tag
    app.controller('mainController', [ '$scope', '$location', function ($scope,$location) {
        // Start hidden
        $scope.showHomeImage = false;

        //Show/hide main image based on the location
        $scope.$on('$locationChangeStart', function(event) {
            $scope.showHomeImage = $location.path() === '/';
        });

        //Activate/Deactivate navbar based on route
        $scope.isTabActive = function (path) {
            return $location.path() === path;
        };
    }]);
})();