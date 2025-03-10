<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'PaymentController::index');
$routes->get('payment', 'PaymentController::index');
$routes->post('payment/process', 'PaymentController::processPayment');
$routes->post('payment/webhook', 'PaymentController::webhook');
$routes->post('payment/confirm', 'PaymentController::confirmPayment');



