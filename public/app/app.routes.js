(function() {
    var app = angular.module('cpAppRoutes', ['ngRoute']);

    app.config(function($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'app/components/home/homeView.html'
            })
            .when('/projects', {
                templateUrl: 'app/components/projects/projectsView.html'
                //controller: 'BookController'
            })
            .otherwise({redirectTo:'/'});


        $locationProvider.html5Mode(false);
    });
})();
