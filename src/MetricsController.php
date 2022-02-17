<?php

declare(strict_types=1);

namespace PhprometheusLaravel;

use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Response;
use Phprometheus\Prometheus;

class MetricsController
{
    protected $prometheus;

    public function __construct(Prometheus $prometheus)
    {
        $this->prometheus= $prometheus;
    }

    public function __invoke(): Response
    {
        $metrics = $this->prometheus->flush();
        $renderer = new RenderTextFormat();

        return new Response($renderer->render($metrics), 200, [ 'Content-Type' => RenderTextFormat::MIME_TYPE ]);
    }
}
