<?php

use Phalcon\Mvc\Router;

$router = new Router();
$router->removeExtraSlashes(true);
$router->setDefaultModule("backend");

//Set 404 paths
$router->notFound(array(
    "module" => "backend",
    "controller" => "notfound",
    "action" => "index"
));
//Define a router index
$router->add("/", array(
    "module" => "backend",
    "controller" => "index",
    "action" => "index"
));
//Set a router not found
$router->add("/notfound", array(
    "module" => "backend",
    "controller" => "notfound",
    "action" => "index"
));

$router->add("/login", array(
    "module" => "backend",
    "controller" => "login",
    "action" => "index"
));



$router->add("/logout", array(
    "module" => "backend",
    "controller" => "login",
    "action" => "logout"
));

$router->add("/accessdenied", array(
    "module" => "backend",
    "controller" => "index",
    "action" => "accessdenied"
));
$router->add("/receipt/{id:(2[0-9]{5})}", array(
    "module" => "backend",
    "controller" => "order",
    "action" => "receipt",
    "type" => "order"
));
$router->add("/receipt/{id:(7[0-9]{5})}", array(
    "module" => "backend",
    "controller" => "order",
    "action" => "receipt",
    "type" => "payment"
));
$router->add("/invoice/{id:(2[0-9]{5})}", array(
    "module" => "backend",
    "controller" => "order",
    "action" => "invoice",
    "type" => "order"
));
$router->add("/invoice/{id:(7[0-9]{5})}", array(
    "module" => "backend",
    "controller" => "order",
    "action" => "invoice",
    "type" => "payment"
));
$router->add(':controller', array(
    "module" => "backend",
    "controller" => 1,
    "action" => "index"
));

$router->add(':controller/:action', array(
    "module" => "backend",
    "controller" => 1,
    "action" => 2
));


$router->handle();
return $router;