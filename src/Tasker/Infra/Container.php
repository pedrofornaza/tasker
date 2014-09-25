<?php

namespace Tasker\Infra;

use Exception;
use InvalidArgumentException;

class Container
{
    protected $data;
    protected $shared;

    public function exists($offset)
    {
        return isset($this->data[$offset]) || isset($this->shared[$offset]);
    }

    public function get($offset)
    {
        if (!isset($this->data[$offset]) &&
             isset($this->shared[$offset])
        ) {
            $this->data[$offset] = $this->shared[$offset]($this);
        }

        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function set($offset, $value)
    {
        $this->data[$offset] = $value;
        return $this;
    }

    public function remove($offset)
    {
        if (isset($this->data[$offset])) {
            unset($this->data[$offset]);

        } elseif (isset($this->shared[$offset])) {
            unset($this->shared[$offset]);
        }
    }

    public function share($offset, $callable)
    {
        if (!is_callable($callable)) {
            throw new InvalidArgumentException('The second parameter must be a callable.');
        }

        $this->shared[$offset] = $callable;
    }

    public function make($className)
    {
        if ( ! class_exists($className)) {
            throw new Exception(sprintf("The namespace '%s' is not class", $className));
        }

        if ($this->exists($className)) {
            return $this->get($className);
        }

        $instance = $this->resolveByReflection($className);
        $this->set($className, $instance);

        return $instance;
    }

    private function resolveByReflection($className)
    {
        $ref = new \ReflectionClass($className);
        if ( ! $ref->isInstantiable()) {
            throw new Exception(sprintf("The class '%s' is not instanciable", $className));
        }

        $constructor = $ref->getConstructor();
        if ($constructor->getNumberOfParameters() != 0) {
            throw new Exception(sprintf("The class '%s' has constructor parameters", $className));
        }

        return new $className;
    }
}
