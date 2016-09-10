<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ URL::asset('css/gift.css') }}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/typehead.css">
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
	<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
</head>
<body ng-app="sampleApp">
<style type="text/css">
	.btn-facebook{color:#fff;background-color:#3b5998;border-color:rgba(0,0,0,0.2)}.btn-facebook:hover,.btn-facebook:focus,.btn-facebook:active,.btn-facebook.active,.open .dropdown-toggle.btn-facebook{color:#fff;background-color:#30487b;border-color:rgba(0,0,0,0.2)}
	.btn-facebook:active,.btn-facebook.active,.open .dropdown-toggle.btn-facebook{background-image:none}
	.btn-facebook.disabled,.btn-facebook[disabled],fieldset[disabled] .btn-facebook,.btn-facebook.disabled:hover,.btn-facebook[disabled]:hover,fieldset[disabled] .btn-facebook:hover,.btn-facebook.disabled:focus,.btn-facebook[disabled]:focus,fieldset[disabled] .btn-facebook:focus,.btn-facebook.disabled:active,.btn-facebook[disabled]:active,fieldset[disabled] .btn-facebook:active,.btn-facebook.disabled.active,.btn-facebook[disabled].active,fieldset[disabled] .btn-facebook.active{background-color:#3b5998;border-color:rgba(0,0,0,0.2)}

</style>
<script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/giftAppHomeController.js') }}"></script>

<h2 class="headClass">Suggestion Based on Your Request</h2>
	<div class="container" ng-controller="myCtrl">
	<input type="hidden" name="currentCategory" ng-model="searchCategory" value="1" />
		<div class="row">
			 <div class="col-sm-2 maindiv3" ng-repeat="sData in suggestionData  | filter:{category:searchCategory}" >
	      <div class="mainDiv3Child">
	        <img ng-src="@{{sData.image}}" class="suggestionImg">
	    </div>
	    <div>
	        <p> @{{sData.name}}</p>
	        <p>Rs @{{sData.price}}</p>
	    </div>
				 <div>
					 <button class="btn btn-primary" style="font-size:12px;" ng-click="facebookLoginLink()">Share Money With Friends</button>
				 </div>
			 </div>
		</div>
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Please Signin</h4>
					</div>
					<div class="modal-body">
						<button class="btn btn-facebook" ng-click="getfacebookfriends()"  style="background-color:#3B5998;font-size:12px;">Signin With Facebook</button>
						<input type="hidden" value="" id="loginLink" name="loginLink" />
					</div>
				</div>

			</div>
		</div>
	</div>



    
<script type="text/javascript">



gifAapp.controller("myCtrl", function($scope,$http) {
var pathname = window.location.pathname; 
var categoryIdArr=pathname.split("/");
var	categoryId=categoryIdArr[(categoryIdArr.length)-1];
	$scope.show=false;
$scope.searchCategory=categoryId;
          $scope.suggestionData=[
  {
    "id":1,
    "categoryName":"Male",
    "category": 1,
    "name": "Wallet Card Wallet",
    "price": "1000",
    "image": "http://img5a.flixcart.com/image/wallet-card-wallet/8/h/g/51105-vbee-s-london-wallet-ribbon-black-125x125-imaejg4mh6wmzacm.jpeg",
    "discount": "25 %",
    "expire": "10 Nov"
  },
  {
    "id":2,
    "category": 1,
    "categoryName":"Male",
    "name": "Mens Combo Watch",
    "price": "1200",
    "image": "http://img5a.flixcart.com/image/apparels-combo/z/g/h/ex-43-nt-efg-06-st-fuschia-exotica-fashions-125x125-imaefn3hnbcj8vae.jpeg",
    "discount": "20 %",
    "expire": "8 Sep"
  },
  {
    "id":3,
    "category": 1,
    "categoryName":"Male",
    "name": "Key Chanin",
    "price": "800",
    "image": "http://img6a.flixcart.com/image/pendant-locket/r/z/v/pnd-0034-yg-iskiuski-125x125-imaegggewzmbfupp.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  },
  {
    "id":4,
    "category": 1,
    "categoryName":"Male",
    "name": "Bracelet Armlet",
    "price": "800",
    "image": "http://img6a.flixcart.com/image/bangle-bracelet-armlet/c/z/b/b1034hcqgmj-2-6-yofashion-1-125x125-imaeazdue6zkr7ug.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  },
  {
    "id":5,
    "category": 2,
    "categoryName":"FeMale",
    "name": "Anklet",
    "price": "600",
    "image": "http://img6a.flixcart.com/image/anklet/q/f/d/ycfjak-001837-gl-yellow-chimes-1-125x125-imaehzk9p8963kkx.jpeg",
    "discount": "25 %",
    "expire": "10 Nov"
  },
  {
    "id":6,
    "category": 2,
    "categoryName":"FeMale",
    "name": "Bangali Bracelet",
    "price": "1200",
    "image": "http://img6a.flixcart.com/image/bangle-bracelet-armlet/s/w/g/ca3015-2-4-carina-1-125x125-imaekd5mmx2fgsbg.jpeg",
    "discount": "20 %",
    "expire": "8 Sep"
  },
  {
    "id":7,
    "category": 2,
    "categoryName":"FeMale",
    "name": "Ring",
    "price": "800",
    "image": "http://img6a.flixcart.com/image/ring/q/v/z/kjrr32-12-12-kanak-ring-125x125-imaehhh7zjguwm9k.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  },
  {
    "id":8,
    "category": 2,
    "categoryName":"FeMale",
    "name": "Analog Watch",
    "price": "800",
    "image": "http://img5a.flixcart.com/image/watch/p/h/f/elbw49-splazos-125x125-imaegxaxpfqncngc.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  },
    {
    "id":9,
    "category": 3,
    "categoryName":"Children",
    "name": "Teady Bear",
    "price": "600",
    "image": "http://img5a.flixcart.com/image/stuffed-toy/p/j/9/cuddles-collections-60-lovely-looking-cute-brown-teady-bear-125x125-imaejdh4swvw2x65.jpeg",
    "discount": "25 %",
    "expire": "10 Nov"
  },
  {
    "id":10,
    "category": 3,
    "categoryName":"Children",
    "name": "Keyboard Learning",
    "price": "1200",
    "image": "http://img6a.flixcart.com/image/musical-toy/g/s/n/unica-rabbit-shaped-keyboard-piano-learning-toy-for-kids-125x125-imaeg7frg2cxxzut.jpeg",
    "discount": "20 %",
    "expire": "8 Sep"
  },
  {
    "id":11,
    "category": 3,
    "categoryName":"Children",
    "name": "School Set",
    "price": "800",
    "image": "http://img6a.flixcart.com/image/school-set/a/7/f/coi-combo-pop-up-ugly-duckling-fairy-tales-story-books-and-125x125-imaehg9nsxb4f92u.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  },
  {
    "id":12,
    "category": 3,
    "categoryName":"Children",
    "name": "Mission Impossible",
    "price": "800",
    "image": "http://img5a.flixcart.com/image/poster/2/k/x/eurekadesigns-mission-impossible-hollywood-poster-edmesku5-125x125-imae8hmy4ppgkx69.jpeg",
    "discount": "5 %",
    "expire": "22 Sep"
  }


];
	$scope.getfacebookfriends=function(){
		var loginUrl=$("#loginLink").val();
		window.location.href=loginUrl;
	}
	$scope.facebookLoginLink=function(){
		$http.get("/FacebookLogin").then(function (response) {
			console.log(response.data);
			var loginUrl=response.data;
			$("#myModal").modal('show');
			$("#loginLink").val(loginUrl);
		});

	}
      });

</script>
</body>
</html>
