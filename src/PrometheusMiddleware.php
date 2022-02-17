<?php

declare(strict_types=1);

namespace PhprometheusLaravel;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Symfony\Component\HttpFoundation\Response;
use Phprometheus\Prometheus;

class PrometheusMiddleware
{
    private $routes;

    private $prometheus;

    public function __construct(Router $router, Prometheus $prometheus)
    {
        $this->routes = $router->getRoutes();
        $this->prometheus = $prometheus;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $route = $this->routes->match($request);

        $start = microtime(true);
        /** @var Response $response */
        $response = $next($request);
        $duration = microtime(true) - $start;

        $this->prometheus->observeHistogram(new RequestDuration([
            'method' => $request->method(),
            'route' => $route->uri(),
            'status_code' => $response->getStatusCode(),
        ]), $duration);

        return $response;
    }
}
