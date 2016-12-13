(function () {
    var mod = angular.module('components');
    
    mod.controller('organisationsController', ['$scope', '$resource', function ($scope, $resource) {
        // Should retrieve this form the API
       $resource('/api/v1/organizations').query(
            function(data) {
                $scope.organisations = data;
            }, function(error) {
                alert("Error: " + error.statusText + " (" + error.status + ")");
            }
        );


    }]);
})();
