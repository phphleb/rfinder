<?php

declare(strict_types=1);

namespace Phphleb\Rfinder;


use Hleb\Constructor\Cache\CacheRoutes;
use Hleb\Constructor\Handlers\URLHandler;

class RouteFinder
{
    private $errors = [];

    public function getErrors() {
        return $this->errors;
    }

    /**
     * @param string|null $url - validated url like `/example/url/address/`
     * @param string|null $method - request method, for example `GET`
     * @param string|null $domain - HTTP HOST, if different from the current one
     * @return bool
     *//**
     * @param string|null $url - проверяемый URL вида `/example/url/address/`
     * @param string|null $method - метод запроса, например `GET`
     * @param string|null $domain - HTTP HOST, если отличается от текущего
     * @return bool
     */
    public function check(string $url, string $method = null, string $domain = null) {
        $url = $url[0] === '/' ? $url : '/' . $url;
        try {
            $routesList = (new CacheRoutes())->load();
            if (empty($routesList)) {
                $errors[] = 'Failed to load route list';
                return false;
            }

            $block = (new URLHandler())->page($routesList, $url, $method, $domain);
            if (empty($block)) {
                $errors[] = 'Failed to retrieve route data';
                return false;
            }
        } catch (\Throwable $exception) {
            $errors[] = 'Error thrown: ' . $exception->getMessage();
            return false;
        }

        return true;
    }

}

