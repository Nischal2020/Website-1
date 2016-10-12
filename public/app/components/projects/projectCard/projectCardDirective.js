(function () {
    var mod = angular.module('directives');

    mod.directive('projectCard', function () {
        return {
            restrict: 'E',
            templateUrl: 'app/components/projects/projectCard/projectCardView.html',
            scope: {
                member : '=data'
            }
        };
    });
})();