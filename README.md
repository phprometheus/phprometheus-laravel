# PHPrometheus (Laravel Edition)

> A lightweight, modular, object-oriented library for exporting metrics to Prometheus.

This is the Laravel-specific package for PHPrometheus. This package aims to provide a higher-level interface over the [officially-sanctioned Prometheus package](https://github.com/PromPHP/prometheus_client_php), at the cost of being slightly more opinionated.

## Installation

Requires PHP 7.3+.

```sh
composer require phprometheus/phprometheus-laravel
```

## Laravel Specifics

Installing and integrating the root `phprometheus/phprometheus` package in your Laravel application will work just fine. However you get some niceties from using this specific package:

- Config integrated "the Laravel way"
- Service providers out of the box
- `/metrics` endpoint included out of the box
- Route middleware included out of the box, for "free" metrics on your endpoints

## Usage

// TODO

## License

This project is released under the MIT license.

Copyright 2022 Kieran Patel

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
