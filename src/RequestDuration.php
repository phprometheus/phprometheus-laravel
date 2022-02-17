<?php

declare(strict_types=1);

namespace PhprometheusLaravel;

use Phprometheus\Histogram;

class RequestDuration extends Histogram
{
    public static function name(): string
    {
        return 'request_duration';
    }

    public static function help(): string
    {
        return 'Request Duration (from middleware)';
    }
}
