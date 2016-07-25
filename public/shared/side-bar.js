app.directive('sideBar', function(){
	return {
		restrict: 'E',
		templateUrl: 'shared/side-bar.html',
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
		controllerAs: 'sidebarCtrl'
	};
});