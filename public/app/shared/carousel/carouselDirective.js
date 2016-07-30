(function () {
    var mod = angular.module('directives');

    mod.directive('carousel', function () {
        return {
            restrict: 'E',
            templateUrl: 'app/shared/carousel/carouselView.html',
            scope: {
                data : '=data'
            }
        };
    });
})();