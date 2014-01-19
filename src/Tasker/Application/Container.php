<?php

namespace Tasker\Application;

use ArrayAccess;
use InvalidArgumentException;

class Container implements ArrayAccess
{
    protected $data;
    protected $shared;

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]) || isset($this->shared[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->data[$offset]) &&
             isset($this->shared[$offset])
        ) {
            $this->data[$offset] = $this->shared[$offset]($this);
        }

        return $this->data[$offset] ? : null;
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
        return $this;
    }

    public function offsetUnset($offset)
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
}
