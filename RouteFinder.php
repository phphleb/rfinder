<?php

declare(strict_types=1);

namespace Phphleb\Rfinder;


use Hleb\Constructor\Cache\CacheRoutes;
use Hleb\Constructor\Handlers\URLHandler;

class RouteFinder
{
    private $errors = [];

    private $currentPath = null;

    private $currentLabel = null;

    private $checked = false;

    /**
     * @param string $url - validated url like `/example/url/address/`
     * @param string|null $method - request method, for example `GET`
     * @param string|null $domain - HTTP HOST, if different from the current one
     *//**
     * @param string $url - ����������� URL ���� `/example/url/address/`
     * @param string|null $method - ����� �������, �������� `GET`
     * @param string|null $domain - HTTP HOST, ���� ���������� �� ��������
     */
    public function __construct(string $url, string $method = 'GET', string $domain = null) {
        $url = $url[0] === '/' ? $url : '/' . $url;
        try {
            $routesList = (new CacheRoutes())->load();
            if (empty($routesList)) {
                $errors[] = 'Failed to load route list';
                $this->checked = false;
                return $this;
            }

            $block = (new URLHandler())->page($routesList, $url, $method, $domain);
            if (empty($block)) {
                $errors[] = 'Failed to retrieve route data';
                $this->checked = false;
                return $this;
            }
            
        } catch (\Throwable $exception) {
            $errors[] = 'Error thrown: ' . $exception->getMessage();
            $this->checked = false;
            return $this;
        }

        $this->currentLabel = $block['number'] ?? null;
        $this->currentPath = $this->getFullPath($block);

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
    public function isValid() {
        return $this->checked;
    }

    /**
     * @return string - template path of the requested route
     *//**
     * @return string - ��������� ���� ���������� �����
     */
    public function getRoutePath() {
        return $this->currentPath;
    }

    /**
     * @return null|int - found route identifier
     *//**
     * @return null|int - ������������� ���������� �����
     */
    public function getRouteLabel() {
        return $this->currentLabel;
    }

    protected function getFullPath(array $block) {
        $prefix = '/';
        foreach($block['actions'] as $action) {
            if(!empty($action['prefix'])) {
                $prefix .= trim($action['prefix'], ' /\\') . '/';
            }
        }

        return str_replace('//', '/', $prefix . trim($block['data_path'], ' /\\') . '/');
    }

}

