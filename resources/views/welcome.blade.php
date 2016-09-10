<!DOCTYPE html>
<html>
    <head>
        <title>Gift App</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="css/typehead.css">
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script>
        <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 90px;
            }
        </style>
    </head>
    <body ng-app="sampleApp" ng-controller="MainController">

        <div class="container">
          <div class="row">
            <div class="col-sm-12">
            <h2>Gift App</h2>
            </div>
          </div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-sm-4" ng-repeat="gift in giftData">
            <input type="radio" ng-modal= "@{{gift.giftcat}}" name="gift" ng-value="@{{option.text}}" ng-checked="getCheckedFalse()">
            @{{gift.giftcat}}
            </div>
            
             <input class="input-large" type="text" ng-model="lastName" typeahead="state.cityName for state in usingCities | filter:$viewValue ">
            
            @{{lastName}}
            
          </div>
        </div>
    


    </body>
    <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/giftAppHomeController.js') }}"></script>

</html>
