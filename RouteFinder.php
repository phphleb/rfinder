<?php


namespace Phphleb\Rfinder;


class RouteFinder
{
    private $route = null;

    private $prefix = null;

    private $method = null;

    private $domain = null;

    private $isFound = false;

    private $isRadjax = false;

    private $label = 0;

    /**
     * @param string $url - search url.
     * @param string $method - request method.
     * @param string|null $domain
     */
    public function __construct(string $url, string $method = 'GET', string $domain = null)
    {
        $this->method = $method;
        $this->domain = $domain;
        $finder = (new RadjaxRouteFinder($url));
        $this->isFound = $finder->isFound();
        if ($this->isFound) {
            // Found a match in the Radjax routes.
            $this->setRouteData($finder);
            $this->isRadjax = true;
            return $this;

        }
        $finder =  (new StandardRouteFinder($url, $method, $domain));
        $this->isFound = $finder->isFound();
        if ($this->isFound) {
            // Found a match in the standard routes.
            $this->setRouteData($finder);
            return $this;
        }
    }

    /**
     * Returns the set domain.
     *
     * Возвращает установленный домен.
     *
     * @return string|null
     */
    public function getDomain(): string
    {
        return $this->domain;
    }

    /**
     * Returns the search result.
     *
     * Возвращает результат поиска.
     *
     * @return bool
     */
    public function isFound(): bool
    {
        return $this->isFound;
    }

    /**
     * Returns the result of checking for the type of the route.
     *
     * Возвращает результат проверки на тип роута.
     *
     * @return bool
     */
    public function isRadjax(): bool
    {
        return $this->isRadjax;
    }

    /**
     * Returns the matched route.
     *
     * Возвращает совпавший роут.
     *
     * @return string|null
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Returns the route prefix from the router.
     *
     * Возвращает префикс роута из маршрутизатора.
     *
     * @return string|null
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Returns the type of the method to search.
     *
     * Возвращает тип метода для поиска.
     *
     * @return string|null
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Returns information about the result of the route search.
     *
     * Возвращает информацию о результате поиска роута.
     *
     * @return string
     */
    public function getInfo() {
        if ($this->isFound()) {
            return "Route not found";
        }
        if ($this->isRadjax()) {
            return "RADJAX ROUTE: №{$this->label} $this->route";
        }

        return "ROUTE: #{$this->label} $this->route" . ($this->domain ? "domain: $this->domain" : "") . ($this->prefix ? "prefix: {$this->prefix}" : "");

    }

    private function setRouteData(RouteFinderInterface $finder)
    {
        $this->route = $finder->getRoutePath();
        $this->prefix = $finder->getPrefix();
        $this->label = $finder->getRouteLabel();
        $this->isFound = true;
    }


}


