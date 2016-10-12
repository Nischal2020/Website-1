<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylorotwell@gmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
>

<!DOCTYPE html>
<html lang="en" ng-app="website">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Clube de Programação da Universidade de Coimbra</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">



   
</head>

<body>

  <my-navbar></my-navbar>

  <div class = "container-fluid full-width">


    <!-- MAIN CONTENT AND INJECTED VIEWS -->
    <div class = "main">
      <!--<side-bar> </side-bar>-->
       <!-- angular templating -->
        <!-- this is where content will be injected -->
        <div ng-view></div>
    </div>


  </div>
  <div class = "clearfix"></div>
  	
  <my-footer></my-footer>

  <!-- angular scripts-->
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.js" ></script>
  <!-- angular bootstrap-->
  <script src="js/bootstrap/ui-bootstrap-tpls-1.3.3.min.js"></script>
  <!-- bootstrap css -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
        integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


  <!-- font awesome -->
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Roboto -->
  <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

  <!-- Modules -->
  <script type="text/javascript" src="app.js" ></script>

  <!-- Directives -->
  <script type="text/javascript" src="shared/my-navbar.js"></script>
  <script type="text/javascript" src ="shared/my-footer.js"></script>
  <script type="text/javascript" src ="shared/side-bar.js"></script>

  <!-- css style -->
  <link rel="stylesheet" type="text/css" href="style.css">


</body>

</html>
