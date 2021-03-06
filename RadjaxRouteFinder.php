<?php

declare(strict_types=1);

namespace Phphleb\Rfinder;

use Radjax\Src\App;

class RadjaxRouteFinder implements RouteFinderInterface
{
    private $errors = [];

    private $currentPath = null;

    private $currentLabel = null;

    private $checked = false;

    /**
     * @param string $url - validated url like `/example/url/address/`
     *//**
     * @param string $url - проверяемый URL вида `/example/url/address/`
     */
    public function __construct(string $url) {
        if (!class_exists('Radjax\Src\App')) {
            $this->checked = false;
            return $this;
        }
        $files = defined('HLEB_RADJAX_PATHS_TO_ROUTE_PATHS') ? HLEB_RADJAX_PATHS_TO_ROUTE_PATHS : [HLEB_LOAD_ROUTES_DIRECTORY . '/radjax.php'];
        try {
            $app = new App($files);
            $isFound = $app->searchRoute($url);
            if (!$isFound){
                $this->checked = false;
                return $this;
            }

        } catch (\Throwable $exception) {
            $this->errors[] = 'Error thrown: ' . $exception->getMessage();
            $this->checked = false;
            return $this;
        }

        $this->currentLabel = $app->getNumber();
        $this->currentPath = $app->getRoute();

        $this->checked = true;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function isFound() {
        return $this->checked;
    }

    /**
     * @return string - template path of the requested route
     *//**
     * @return string - шаблонный путь найденного роута
     */
    public function getRoutePath() {
        return $this->currentPath;
    }

    /**
     * @return null|int - found route identifier
     *//**
     * @return null|int - идентификатор найденного роута
     */
    public function getRouteLabel() {
        return $this->currentLabel;
    }

    /**
     * Returns the combined prefix.
     * @return string
     *//**
     * Возвращает объединённы префикс.
     * @return string
     */
    public function getPrefix() {
        return '';
    }

}

