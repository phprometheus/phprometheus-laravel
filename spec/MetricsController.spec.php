<?php

declare(strict_types=1);

use Phprometheus\Counter;
use Prometheus\Storage\InMemory;
use Prometheus\CollectorRegistry;
use Phprometheus\PrometheusExporter;
use PhprometheusLaravel\MetricsController;

describe(MetricsController::class, function () {
    given('registry', function () {
        return new CollectorRegistry(new InMemory(), false);
    });

    given('counter', function () {
        return new class extends Counter {
            public static function name(): string
            {
                return 'example_counter';
            }

            public static function help(): string
            {
                return 'An example counter';
            }
        };
    });

    it('exposes metrics via HTTP response', function () {
        $prometheus = new PrometheusExporter('ns', $this->registry);
        $prometheus->incrementCounter($this->counter, 3);

        $controller = new MetricsController($prometheus);
        $response = $controller();

        expect($response->isOk())->toBeTruthy();
        expect((string) $response)->toContain('ns_example_counter 3');
    });
});
