<?php

require 'autoload.php';

$router = new \App\Services\Router();
$router->post('/api/order/calculate', [\App\Controllers\ApiOrderController::class, 'calculate']);
$router->run();