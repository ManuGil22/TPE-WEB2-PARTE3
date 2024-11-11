<?php
    
    require_once 'app/libs/router.php';
    require_once 'app/controllers/trip.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';
    require_once 'app/middlewares/jwt.auth.middleware.php';

    $router = new Router();

    $router->addMiddleware(new JWTAuthMiddleware());

    $router->addRoute('trips'      , 'GET' , 'TripApiController', 'getAllTrips');
    $router->addRoute('trips/:id'  , 'GET' , 'TripApiController', 'getTrip');
    $router->addRoute('trips/:id'  , 'PUT' , 'TripApiController', 'editTrip');
    $router->addRoute('trips'      , 'POST', 'TripApiController', 'addTrip');

    $router->addRoute('users/token', 'GET', 'UserApiController', 'getToken');

    $router->route($_GET['action'], $_SERVER['REQUEST_METHOD']);