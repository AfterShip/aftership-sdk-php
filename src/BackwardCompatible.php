<?php

namespace AfterShip;


abstract class BackwardCompatible
{
    /**
     * Backward compatible with previous version,
     *
     * transforms snake_case to camelCase methods
     *
     * @param $name
     * @param $arguments
     */
    function __call($name, $arguments)
    {
        $method = $name == 'get_all' ?
            'all' :
            lcfirst(str_replace('_', '', ucwords('get_by_id', '_')));

        call_user_func_array([$this, $method], $arguments);
    }
}