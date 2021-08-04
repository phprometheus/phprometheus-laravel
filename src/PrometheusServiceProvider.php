<?php

declare(strict_types=1);

namespace Phprometheus\Laravel;

use Prometheus\Storage\APC;
use Psr\Log\LoggerInterface;
use Prometheus\Storage\Redis;
use UnexpectedValueException;
use Illuminate\Routing\Router;
use Prometheus\Storage\Adapter;
use Prometheus\Storage\InMemory;
use Prometheus\CollectorRegistry;
use PrometheusPushGateway\PushGateway;
use Illuminate\Support\ServiceProvider;
use Phprometheus\Prometheus;
use Phprometheus\PrometheusExporter;
use Phprometheus\AbstractPrometheus;
use Phprometheus\PrometheusPushGateway;

class PrometheusServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
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
            if (config('prometheus.push_gateway.enabled')) {
                return new PrometheusPushGateway(
                    config('prometheus.namespace'),
                    config('prometheus.push_gateway.job'),
                    new PushGateway(config('prometheus.push_gateway.url')),
                    $this->app->get(LoggerInterface::class),
                );
            }

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
