<?php


namespace Phphleb\Rfinder;


interface RouteFinderInterface
{
    public function getErrors();

    public function isFound();

    public function getRoutePath();

    public function getRouteLabel();

    public function getPrefix();
}