<?php

declare(strict_types=1);

namespace Pagination;

use Pagination\Middleware\PaginationMiddleware;
use Pagination\Middleware\PaginationMiddlewareFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            "templates" => $this->getTemplates(),
        ];
    }

    public function getDependencies(): array
    {

        return [
            "invokables" => [],
            'factories' => [PaginationMiddleware::class => PaginationMiddlewareFactory::class
            ]
        ];
    }
     /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return ["paths" => []];
    }
}
