<?php

namespace App\Core;

class Node extends RootNode
{
    private string $value;

    public function __construct(string $value)
    {
        parent::__construct();

        if ($value == '') throw new \InvalidArgumentException("Value cannot be '$value'");
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
