<?php

namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class TrailingMiddleware
{

    /**
     * __invoke
     * This middleware will remove the last '/' trailing slash in the uri
     * @param  Request $request
     * @param  Response $response
     * @param  mixed $next
     * @return Response
     */
    public function __invoke(Request $request, Response $response, $next)
    {
        $uri = $request->getUri();
        $path = $uri->getPath();

        if ($path != '/' && substr($path, -1) == '/') {
            // permanently redirect paths with a trailing slash
            // to their non-trailing counterpart
            $uri = $uri->withPath(substr($path, 0, -1));

            if($request->getMethod() == 'GET') {
                var_dump($uri); die;
                return $response->withRedirect((string)$uri, 301);
            }
            else {
                return $next($request->withUri($uri), $response);
            }
        }

        // before this point the code is launched before the page rendering
        return $next($request, $response);
        // after this point the code is launched after the page rendering
    }
}
