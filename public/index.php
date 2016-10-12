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
?>

<!DOCTYPE html>
<html ng-app="cpApp">
<head>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <meta name="keywords" content="tech, programming, association">
    <meta name="description" content="Lorem ipsum dolor sit amet, consectetur adipisici eli.">
    <title>Clube de Programação</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--boostrap setup-->
    <script type="text/javascript" src="assets/libs/jquery.min.js"></script>
    <script type="text/javascript" src="assets/libs/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
          type="text/css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" type="text/css">

    <!--angular setup-->
    <script type="text/javascript" src="assets/libs/angular.min.js"></script>
    <script type="text/javascript" src="assets/libs/angular-route.min.js"></script>
    <script type="text/javascript" src="app/app.module.js"></script>
</head>
<body>

<!--navbar-->
<div class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img alt="Brand" class="navbar-brand-img" height="27px" style="margin-top: -4px;"
                     src="assets/img/logo.png">
            </a>
            <a class="navbar-brand" href="/">
                <span>Clube de Programação</span>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="projects.html">Projects</a>
                </li>
                <li class="">
                    <a href="members.html">Members</a>
                </li>
                <li>
                    <a href="events.html">Events</a>
                </li>
                <li>
                    <a href="blog.html">Blog<br></a>
                </li>
                <li>
                    <a href="organisations.html">Organisations<br></a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="cover">
    <div class="cover-image"
         style="background-image: url(https://unsplash.imgix.net/photo-1418065460487-3e41a6c84dc5?q=25&amp;fm=jpg&amp;s=127f3a3ccf4356b7f79594e05f6c840e);"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h1 class="text-inverse">Welcome</h1>
                <p class="text-inverse">Lorem ipsum dolor sit amet, consectetur adipisici eli.</p>
                <br>
                <br>
                <a class="btn btn-lg btn-success">Sign-up now!</a>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
            </div>
            <div class="col-md-6">
                <h1 class="text-primary">What we do</h1>
                <h3>A subtitle</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
                    ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
                    dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
                    nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
                    Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                    enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
                    felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
                    elementum semper nisi.</p>
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="text-primary">Why you should engage now</h1>
                <h3>A subtitle</h3>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo
                    ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis
                    dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies
                    nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
                    Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In
                    enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
                    felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus
                    elementum semper nisi.</p>
            </div>
            <div class="col-md-6">
                <img src="http://pingendo.github.io/pingendo-bootstrap/assets/placeholder.png" class="img-responsive">
            </div>
        </div>
    </div>
</div>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center text-primary">People</h1>
                <p class="text-center">We are a group of skilled individuals.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png"
                     class="center-block img-circle img-responsive">
                <h3 class="text-center">John Doe</h3>
                <p class="text-center">Developer</p>
            </div>
            <div class="col-md-4">
                <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png"
                     class="center-block img-circle img-responsive">
                <h3 class="text-center">John Doe</h3>
                <p class="text-center">Developer</p>
            </div>
            <div class="col-md-4">
                <img src="http://pingendo.github.io/pingendo-bootstrap/assets/user_placeholder.png"
                     class="center-block img-circle img-responsive">
                <h3 class="text-center">John Doe</h3>
                <p class="text-center">Developer</p>
            </div>
        </div>
    </div>
</div>

<!--footer-->
<footer class="section section-primary">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Footer header</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisici elit,
                    <br>sed eiusmod tempor incidunt ut labore et dolore magna aliqua.
                    <br>Ut enim ad minim veniam, quis nostrud</p>
            </div>
            <div class="col-sm-6">
                <p class="text-info text-right">
                    <br>
                    <br>
                </p>
                <div class="row">
                    <div class="col-md-12 hidden-lg hidden-md hidden-sm text-left">
                        <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 hidden-xs text-right">
                        <a href="#"><i class="fa fa-3x fa-fw fa-instagram text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-twitter text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-facebook text-inverse"></i></a>
                        <a href="#"><i class="fa fa-3x fa-fw fa-github text-inverse"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


</body>
</html>
