<?php
namespace Tenon\Application;

use Tenon\Contracts\Application\ContainerContract;
use Closure;


/**
 * 容器基类
 * Class Container
 * @package Tenon\Application
 */
class Container implements ContainerContract
{
    /**
     * @var array
     */
    protected $bindings = [];

    /**
     * @var array
     */
    protected $instances = [];

    /**
     * @param $abstract
     * @param Closure $concrete
     */
    public function bind($abstract, Closure $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * 绑定单例
     * @param string $abstract
     * @param object $concrete
     */
    public function instance($abstract, $concrete)
    {
        $this->instances[$abstract] = $concrete;
    }

    /**
     * @todo: add reflection detecting
     * @param $abstract
     * @param array $parameters
     * @param bool|true $isSingleton
     * @return object/null
     */
    public function make($abstract, array $parameters = [], $isSingleton = true)
    {
        //from instances
        if(isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        //from bindings
        elseif(isset($this->bindings[$abstract])) {
            $concrete = $this->bindings[$abstract];
            $instance = $concrete($this, $parameters);
            if($isSingleton) {
                $this->instances[$abstract] = $instance;
            }
            return $instance;
        }
        //cannot be found
        else {
            return null;
        }
    }

}