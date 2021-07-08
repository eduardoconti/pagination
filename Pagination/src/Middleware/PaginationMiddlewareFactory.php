<?php

declare(strict_types=1);

namespace Pagination\Middleware;

use Psr\Container\ContainerInterface;

class PaginationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PaginationMiddleware
    {
        return new PaginationMiddleware($container);
    }
}
