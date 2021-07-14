<?php

declare(strict_types=1);

namespace DoctrinePagination\Middleware;

use Laminas\ServiceManager\ServiceManager;
use Psr\Container\ContainerInterface;
use Throwable;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use DTO\Params;

class PaginationMiddleware implements MiddlewareInterface
{
    /**
     * @var ServiceManager
     */
    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            if ($request->getMethod() == 'GET') {
                $queryParams = $request->getQueryParams();
                $params = new Params($queryParams);
                $this->container->setService("paramsRequestPagination", $params);
                return $handler->handle($request);
            }
        } catch (Throwable $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
       
    }
}
