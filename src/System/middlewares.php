<?php
// add the middleware for all the application
$app->add(new App\Middleware\TrailingMiddleware());
$app->add(new App\Middleware\FlashMiddleware($container));
