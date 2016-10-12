(function () {
    var mod = angular.module('directives');

    mod.directive('memberCard', function () {
        return {
            restrict: 'E',
            templateUrl: 'app/components/members/memberCard/memberCardView.html',
            scope: {
                member : '=data'
            }
        };
    });
})();