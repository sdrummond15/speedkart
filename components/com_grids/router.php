<?php

defined('_JEXEC') or die;

class GridsRouter extends JComponentRouterBase{

    public function build(&$query)
    {

        $segments = array();

        if (isset($query['view']))
        {
            $segments[] = $query['view'];
            unset($query['view']);
        }

        if(isset($query['id']))
        {
            $segments[] = $query['id'];
            unset($query['id']);
        };

        return $segments;

    }

    public function parse(&$segments)
    {

        $vars = array();

        $vars['view'] = $segments[0];

        if(isset($segments[1])){
            $id = explode('_', $segments[1]);
            $vars['id'] = $id[0];
        }

        return $vars;

    }
}

function gridsBuildRoute(&$query)
{
    $router = new GridsRouter;

    return $router->build($query);
}

function gridsParseRoute($segments)
{
    $router = new GridsRouter;

    return $router->parse($segments);
}
