<?php

use App\Controller\MainController;
use App\Controller\AuthController;
use App\Controller\SignUpController;
use App\Controller\AdminController;
use Slim\Http\Request;
use Slim\Http\Response;

// --------- COMMON PART OF THE WEBSITE ---------
//Home
$app->get('/', MainController::class.':index')->setName('app.index');

$app->get('/home', MainController::class.':index')->setName('app.index');

//Team
$app->get('/team', MainController::class.':team')->setName('app.team');

//Articles
$app->get('/articles', MainController::class.':articles')->setName('app.articles');

//Article
$app->get('/article{article_id}', MainController::class.':article')->setName('app.article');


//Article by cat
$app->get('/artByCat{category_id}', MainController::class.':articlesByCat')->setName('app.articles');

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
//dashboard
$app->get('/adm_dashboard', AdminController::class.':dashboard')->setName('adm.dashboard')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->get('/adm_add_articles', AdminController::class.':addArticles')->setName('adm.addArticles');

$app->get('/adm_articles', AdminController::class.':articles')->setName('adm_articles');

$app->post('/adm_articles', AdminController::class.':articlesAction')->setName('adm_articles');

$app->get('/adm_cat', AdminController::class.':categories')->setName('adm_cat');

$app->post('/adm_cat', AdminController::class.':categoriesAction')->setName('adm_cat');

$app->get('/adm_media', AdminController::class.':media')->setName('adm_media')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->get('/adm_users', AdminController::class.':users')->setName('adm_users')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->post('/adm_users', AdminController::class.':usersAction')->setName('adm_users')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->get('/adm_users/delete_{username}', AdminController::class.':userDelete')->setName('adm_users')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->get('/adm_users/edit_{id}', AdminController::class.':fillUserEdit')->setName('adm_users_edit')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->post('/adm_users/edit_{id}', AdminController::class.':userEdit')->setName('adm_users')->add(new \App\Middleware\AdminPermissionMiddleware($container));

$app->get('/adm_cat/delete_{category_id}', AdminController::class.':catDelete')->setName('adm_cat');

$app->get('/adm_cat/edit_{category_id}', AdminController::class.':FillCatEdit')->setName('adm_cat_edit');

$app->post('/adm_cat/edit_{category_id}', AdminController::class.':catEdit')->setName('adm_cat');

$app->get('/adm_articles/delete_{article_id}', AdminController::class.':articleDelete')->setName('adm_articles');

$app->get('/adm_articles/edit_{article_id}', AdminController::class.':FillArticleEdit')->setName('adm_articles_edit');

$app->post('/adm_articles/edit_{article_id}', AdminController::class.':articleEdit')->setName('adm_articles');


// --------- END OF ADMIND PART ---------
