@extends('template')
<div ng-controller="MainController">
<h1 class="headClass">My Gift App</h1>
<div class="bottom_border"></div>
<div class="container-fluid">
	<br>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="https://www.budsies.com/blog/wp-content/uploads/2016/05/gift-8.jpg" alt="Main Gift" class="home_image" >
			</div>

			<div class="item">
				<img src="http://img6a.flixcart.com/www/promos/new/20160828_212128_730x300_image-730-300-32.jpg" class="home_image">
			</div>
		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>

<br><br>
<div class="container">
	<div class="row">
		 <div class="col-sm-3">
			<label class="radio-inline"><input type="radio" ng-model="value" value="male" ng-change='newValue(value)'>Male</label>
		 </div>
		 <div class="col-sm-3">
			<label class="radio-inline"><input type="radio" ng-model="value" value="female" ng-change='newValue(value)'>Female</label>
		 </div>
		 <div class="col-sm-3">
			<label class="radio-inline"><input type="radio" ng-model="value" value="children" ng-change='newValue(value)'>Children</label>
		 </div>
		 <div class="col-sm-3">
			<label class="radio-inline"><input type="radio" ng-model="value" value="couples" ng-change='newValue(value)'>Couples</label>
		 </div>

	</div>
</div>

<div class="container">
	<div class="row">
		 <div class="col-sm-12">
			<button type="button" class="btn btn-primary go_button" ng-click="gotoLink()">GO</button>
		 </div>
	</div>
</div>
