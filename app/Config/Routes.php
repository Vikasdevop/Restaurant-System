<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'restaurantController::login');
$routes->get('login', 'restaurantController::login');
$routes->post('login', 'restaurantController::loginUser');
$routes->get('logout', 'restaurantController::logout');
$routes->get('register', 'restaurantController::register');
$routes->post('register_restaurant', 'restaurantController::registerUser');
// $routes->post('RestaurantUsers/register', 'restaurantController::registerUser');


$routes->get('/customer/register', 'restaurantController::customerRegister');
$routes->post('/customerRegisterUser', 'restaurantController::customerRegisterUser');
$routes->get('/CustomerUsers/register', 'CustomerController::saveLocation');
$routes->get('CustomerUsers/dashboard', 'CustomerController::dashboard');
// $routes->get('restaurant/menu/(:num)', 'restaurantController::viewMenu/$1');
$routes->post('CustomerUsers/dashboard', 'restaurantController::findNearbyRestaurants');

$routes->get('/menu', 'menuController::index');
$routes->get('/menu', 'menuController::menu');
$routes->get('/menu/category/(:segment)', 'menuController::view/$1');
$routes->get('/menu/add', 'menuController::add');
$routes->post('/menu/store', 'menuController::store');
$routes->post('/menu/delete/(:num)', 'menuController::deleteMenuItem/$1');
$routes->get('/cart/getItemQuantityLimit/(:num)', 'menuController::getItemQuantityLimit/$1');
$routes->post('cart/getItemQuantityLimit', 'menuController::setItemQuantityLimit');
$routes->get('restaurants/search', 'CustomerController::search');

//
$routes->get('/menu/profile', 'menuController::profile');
$routes->post('/menu/updateProfile', 'menuController::updateProfile');
//
$routes->get('/menu/x/(:num)', 'menuController::viewmenu/$1');
$routes->post('restaurant/toggle_status', 'menuController::toggle_status');


$routes->get('customer/viewMenu/(:num)', 'CustomerController::viewMenu/$1');
$routes->get('customer/viewMenu/(:segment)', 'CustomerController::viewMenu/$1');

$routes->post('/logout', 'CustomerController::logout');
$routes->get('/get-restaurants', 'RestaurantController::getRestaurants');

$routes->get('/restaurants', 'CustomerController::viewRestaurants'); // To display restaurants

//
// $routes->post('CustomerUsers/dashboard', 'CustomerController::addToFavorite');
// $routes->post('CustomerUsers/dashboard', 'CustomerController::removeFavorite'); // To remove a favorite
// $routes->post('CustomerUsers/dashboard', 'CustomerController::toggleFavorite');
//

$routes->post('/dashboard/addToFavorite/(:num)', 'CustomerController::addToFavorite/$1');
$routes->post('/dashboard/removeFromFavorite/(:num)', 'CustomerController::removeFromFavorite/$1');
$routes->post('CustomerUsers/dashboard/toggleFavorite/(:num)', 'CustomerController::toggleFavorite/$1');

// $routes->get('CustomerUsers/Payment', 'PaymentController::index');
$routes->get('CustomerUsers/Payment', 'menuController::showCart');


$routes->post('menu/x/api/add-item', 'menuController::addToCart');
$routes->get('api/delete-item/(:num)', 'menuController::deleteFromCart/$1');
$routes->post('CustomerUsers/api/confirmPayment-api', 'menuController::confimPaymentAPI');