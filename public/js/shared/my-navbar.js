app.directive('myNavbar', function(){
	return {
		restrict: 'E',
		templateUrl: './app/shared/my-navbar.html',
		controller: function(){
			this.active = -1;
			this.logged = false;
			this.setActive = function(activeIndex){
				this.active = activeIndex;
			};
			this.isActive = function(activeIndex){
				return this.active===activeIndex;
			};
			this.setLogged = function(){
				this.logged = true;
			};

			this.isLogged = function(){
				return this.logged;
			};
		},
		controllerAs: 'navbarCtrl'
	};
});