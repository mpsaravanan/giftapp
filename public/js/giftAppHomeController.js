gifAapp.controller("MainController", function($http,$scope) {
    $scope.firstName = "John";
    $scope.lastName = "Doe";
    $scope.suggestionData= [];
  
	$scope.newValue = function(value) {
	  	$scope.userType = value;
	     console.log(value);
	} 

	$scope.gotoLink = function (val) {

		if(!$scope.userType) return;
		window.location = window.location.protocol + "//" + window.location.host + "/giftAdd/"+$scope.userType;
		$scope.firstDiv = true;
	}

$http.get("giftAdTree")
    .then(function(response) {
        $scope.giftData = response.data;
      
        console.log($scope.giftData);    

  });

});