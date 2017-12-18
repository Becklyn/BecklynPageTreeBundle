<?php

namespace Tests\Becklyn\RouteTreeBundle;

use Symfony\Component\Routing\Route;


/**
 *
 */
trait RouteTestTrait
{
    /**
     * Generates a route
     *
     * @param string $path
     * @param array  $treeData
     *
     * @return Route
     */
    protected function generateRoute ($path, array $treeData = [])
    {
        $options = !empty($treeData)
            ? ["tree" => $treeData]
            : [];

        return new Route(
            $path,
            [], // $defaults
            [], // $requirements
            $options
        );
    }
}