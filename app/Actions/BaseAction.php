<?php

namespace App\Actions;

use Illuminate\Contracts\Container\BindingResolutionException;

abstract class BaseAction
{
    public function handle($data, \Closure $next)
    {
        $result = $this->action($data);

        return $next($result);
    }

    public abstract function action($args);

    /**
     * Call directly Action class function
     * 
     * @param string $actionClass 
     * @param mixed $data 
     * @param string $via 
     * @return mixed 
     * @throws BindingResolutionException 
     */
    public function do($actionClass, $data, $via = 'action')
    {
        return app($actionClass)->{$via}($data);
    }
}
