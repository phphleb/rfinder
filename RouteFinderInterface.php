<?php


namespace Phphleb\Rfinder;


interface RouteFinderInterface
{
    public function getErrors();

    public function isValid();

    public function getRoutePath();

    public function getRouteLabel();
}