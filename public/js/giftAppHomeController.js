gifAapp.controller("MainController", function($http,$scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
     $scope.usingCities=[
       { cityId:'100000', cityName:'Chennai'},
       { cityId:'200000', cityName:'Bangalore'},
       { cityId:'300000', cityName:'Hyderabad'},
       { cityId:'400000', cityName:'Coimbatore'},
       { cityId:'500000', cityName:'Mysore'},
       { cityId:'600000', cityName:'Kochi'},
       { cityId:'700000', cityName:'Pune'},
       { cityId:'800000', cityName:'Mumbai'}
   ];
	$scope.newValue = function(value) {
	  	$scope.userType = value;
	     console.log(value);
	} 

	$scope.gotoLink = function () {
		
		if(!$scope.userType) return;
		window.location = window.location.protocol + "//" + window.location.host + "/giftAdd";
		$scope.firstDiv = true;
	}

$http.get("giftAdTree")
    .then(function(response) {
        $scope.giftData = response.data;
      
        console.log(response);    

    });


});