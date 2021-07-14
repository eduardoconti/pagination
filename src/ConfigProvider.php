<?php

declare(strict_types=1);

namespace DoctrinePagination;

use DoctrinePagination\Middleware\PaginationMiddleware;
use DoctrinePagination\Middleware\PaginationMiddlewareFactory;

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
