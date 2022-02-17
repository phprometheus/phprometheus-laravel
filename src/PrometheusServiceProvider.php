<?php

declare(strict_types=1);

namespace PhprometheusLaravel;

use Prometheus\Storage\APC;
use Prometheus\Storage\Redis;
use UnexpectedValueException;
use Illuminate\Routing\Router;
use Prometheus\Storage\Adapter;
use Prometheus\Storage\InMemory;
use Prometheus\CollectorRegistry;
use Illuminate\Support\ServiceProvider;
use Phprometheus\Prometheus;
use Phprometheus\PrometheusExporter;

class PrometheusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/phprometheus.php' => config_path('phprometheus.php')
        ], 'config');
        $this->loadRoutes();
    }

    public function register(): void
    {
        $this->app->bind(Adapter::class, function () {
            switch (config('prometheus.storage_adapter')) {
                case 'apc':
                    return new APC();
                case 'redis':
                    return new Redis(config('prometheus.redis'));
                case 'memory':
                    return new InMemory();
                default:
                    throw new UnexpectedValueException(sprintf(
                        'Unknown Prometheus storage adapter supplied: `%s`',
                        config('prometheus.storage_adapter'),
                    ));
            }
        });

        $this->app->bind(Prometheus::class, function () {
            return new PrometheusExporter(
                config('prometheus.namespace'),
                new CollectorRegistry($this->app->get(Adapter::class)),
            );
        });
    }

    private function loadRoutes()
    {
        if (! config('prometheus.metrics_route')) {
            return;
        }

        $router = $this->app->get(Router::class);
        $router->get(
            config('prometheus.metrics_route'),
            MetricsController::class,
        )->name('metrics');
    }
}
