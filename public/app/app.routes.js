(function() {
    var app = angular.module('cpAppRoutes', ['ngRoute']);

    app.config(function($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'app/components/home/homeView.html'
            })
            .when('/projects', {
                templateUrl: 'app/components/projects/projectsView.html'
            })
            .when('/blog', {
                templateUrl: 'app/components/blog/blogView.html'
                //controller: 'BlogController'
            })
            .when('/events', {
                templateUrl: 'app/components/events/eventsView.html'
                //controller: 'BlogController'
            })
            .when('/members', {
                templateUrl: 'app/components/members/membersView.html'
                //controller: 'BlogController'
            })
            .when('/organisations', {
                templateUrl: 'app/components/organisations/organisationsView.html'
                //controller: 'BlogController'
            })
            .when('', {redirectTo:'/'})
            .otherwise({redirectTo:'/'});


        $locationProvider.html5Mode(false);
    });
})();
