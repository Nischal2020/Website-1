
(function () {
    var mod = angular.module('directives');

    mod.directive('organisationCard', function () {
        return {
            restrict: 'E',
            templateUrl: 'app/components/organisations/organisationCard/organisationCardView.html',
            scope: {
                organisation : '=data'
            }
        };
    });
})();