<?php

namespace Tasker\Domain;

interface FactoryInterface
{
    public function build($data);
}