<?php

namespace Becklyn\RouteTreeBundle\Tree;

use Becklyn\RouteTreeBundle\Builder\TreeBuilder;
use Becklyn\RouteTreeBundle\Cache\TreeCache;
use Becklyn\RouteTreeBundle\Tree\Processing\PostProcessing;
use Symfony\Component\Routing\RouterInterface;


/**
 *
 */
class RouteTree
{
    const TREE_TRANSLATION_DOMAIN = "route_tree";

    /**
     * @var Node[]
     */
    private $tree = null;


    /**
     * @var TreeBuilder
     */
    private $builder;


    /**
     * @var TreeCache
     */
    private $cache;


    /**
     * @var PostProcessing
     */
    private $postProcessing;


    /**
     * @var RouterInterface
     */
    private $router;



    /**
     * @param TreeBuilder     $builder
     * @param TreeCache       $cache
     * @param PostProcessing  $postProcessing
     * @param RouterInterface $router
     */
    public function __construct (TreeBuilder $builder, TreeCache $cache, PostProcessing $postProcessing, RouterInterface $router)
    {
        $this->builder = $builder;
        $this->cache = $cache;
        $this->postProcessing = $postProcessing;
        $this->router = $router;
    }



    /**
     * Builds the tree
     *
     * @return Node[]
     */
    private function buildTree ()
    {
        $tree = $this->cache->getTree();

        if (null === $tree)
        {
            $tree = $this->builder->buildTree($this->router->getRouteCollection());
            $this->cache->setTree($tree);
        }

        return $this->postProcessing->postProcessTree($tree);
    }



    /**
     * Fetches a node from the tree
     *
     * @param string $route
     *
     * @return Node|null
     */
    public function getNode ($route)
    {
        if (null === $this->tree)
        {
            $this->tree = $this->buildTree();
        }

        return isset($this->tree[$route])
            ? $this->tree[$route]
            : null;
    }
}
