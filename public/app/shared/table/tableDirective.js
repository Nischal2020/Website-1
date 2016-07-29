(function () {
    var mod = angular.module('directives');
    
    mod.directive('table', function () {
       return {
           restrict: 'E',
           templateUrl: 'app/shared/table/tableView.html',
           scope: {
               data : '=data'
           }
       };
    });
})();