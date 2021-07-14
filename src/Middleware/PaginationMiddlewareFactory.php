<?php

declare(strict_types=1);

namespace DoctrinePagination\Middleware;

use Psr\Container\ContainerInterface;

class PaginationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PaginationMiddleware
    {
        return new PaginationMiddleware($container);
    }
}
