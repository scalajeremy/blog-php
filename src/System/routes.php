<?php

use App\Controller\MainController;
use App\Controller\AuthController;
use App\Controller\SignUpController;
use App\Controller\AdminController;
use Slim\Http\Request;
use Slim\Http\Response;

// this is a route directly implemented
// --------- COMMON PART OF THE WEBSITE ---------
//Home
$app->get('/', MainController::class.':index')->setName('app.index');

$app->get('/home', MainController::class.':index')->setName('app.index');

//Team
$app->get('/team', MainController::class.':team')->setName('app.team');

//Articles
$app->get('/articles', MainController::class.':articles')->setName('app.articles');

//Login
$app->get('/login', AuthController::class.':login')->setName('app.login');

$app->post('/login', AuthController::class.':loginAction')->setName('app.login');

//Logout
$app->get('/logout', AuthController::class.':logoutAction')->setName('app.logout');

//Sign up
$app->get('/signup', SignUpController::class.':signup')->setName('app.signup');

$app->post('/signup', SignUpController::class.':signupAction')->setName('app.signup');

// --------- END OF COMMON PART ---------

// --------- AUTHOR PART ---------

// --------- END OF AUTHOR ---------

// --------- ADMIN PART ---------
$app->get('/adm_dashboard', AdminController::class.':dashboard')->setName('adm.dashboard');

$app->get('/adm_add_articles', AdminController::class.':addArticles')->setName('adm.addArticles');

$app->get('/adm_articles', AdminController::class.':articles')->setName('adm.articles');

$app->post('/adm_articles', AdminController::class.':articlesAction')->setName('adm.articles');

$app->get('/adm_cat', AdminController::class.':categories')->setName('adm.categories');

$app->post('/adm_cat', AdminController::class.':categoriesAction')->setName('adm.categories');

$app->get('/adm_media', AdminController::class.':media')->setName('adm_media');

$app->get('/adm_users', AdminController::class.':users')->setName('adm_users');

$app->post('/adm_users', AdminController::class.':usersAction')->setName('adm_users');

$app->get('/adm_users/delete_{username}', AdminController::class.':userDelete')->setName('adm_users');

////////////
// --------- END OF ADMIND PART ---------
/*

// defining a route group, in that case all uri will have /post then the path added in the group

$app->group('/post', function(){
    $this->get('', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');

});
*/
