<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Route
$routes->get('/', 'Home::index');

$routes->get('/login', 'Auth::login');
$routes->post('/auth/loginSubmit', 'Auth::loginSubmit');
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/adminPage', 'Auth::adminPage');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/profile', 'DashboardController::profile');
$routes->get('/profile', 'ProfileController::index');

//edit profile routes
$routes->get('/editProfile', 'ProfileController::editProfile');
$routes->post('/editProfile', 'ProfileController::updateProfile');


$routes->get('/adminPage', 'AdminController::index');
$routes->get('/adminPage/addUser', 'AdminController::addUser');
$routes->post('/user/save', 'AdminController::saveUser');
$routes->get('/adminPage/removeUser', 'AdminController::removeUser');
$routes->post('/user/remove', 'AdminController::deleteUser');
$routes->get('/adminPage/addDocType', 'AdminController::addDocType');
$routes->post('/adminPage/saveDocType', 'AdminController::saveDocType');

$routes->get('/adminPage/editDocType', 'AdminController::editDocType');
$routes->post('/adminPage/deleteDocType', 'AdminController::deleteDocType');


$routes->post('/updatePassword', 'ProfileController::updatePassword');

$routes->get('/documents/submit', 'DocumentsController::submitDocuments'); 
$routes->post('/documents/upload', 'DocumentsController::upload');
$routes->get('/checkStatus', 'DocumentsController::checkStatus');
$routes->get('/documents/view/(:num)', 'DocumentsController::view/$1');
$routes->get('/documents/review', 'DocumentsController::review');

$routes->get('/documents/reviewDocument/(:num)', 'DocumentsController::reviewDocument/$1');
$routes->post('documents/decision', 'DocumentsController::decision');

$routes->get('/adminPage/seeUsers', 'AdminController::seeUsers');
$routes->get('/adminPage/getUsers', 'AdminController::getUsers'); // API to fetch users

$routes->post('/adminPage/updateUserStatus', 'AdminController::updateUserStatus');

$routes->get('support', 'SupportController::index');

