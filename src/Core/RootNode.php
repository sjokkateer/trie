<?php

namespace App\Core;

class RootNode
{
    private array $nodes;

    public function __construct()
    {
        $this->nodes = [];
    }

    /** @return array<Node> */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function getNode(string $value): ?Node
    {
        $value = strtolower($value);

        if (!key_exists($value, $this->nodes)) return null;

        return $this->nodes[$value];
    }

    public function add(Node $node)
    {
        if (!key_exists($node->getValue(), $this->nodes)) {
            $this->nodes[strtolower($node->getValue())] = $node;
        }
    }
}
