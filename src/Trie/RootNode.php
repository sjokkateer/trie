<?php

namespace Sjokkateer\Trie;

class RootNode
{
    private static int $id = 0;

    private int $nodeId;
    private array $nodes;

    public function __construct()
    {
        $this->nodeId = static::$id++;
        $this->nodes = [];
    }

    public function getId(): int
    {
        return $this->nodeId;
    }

    /** @return array<Node> */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function getNode(string $value): ?Node
    {
        if (key_exists($value, $this->nodes)) return $this->nodes[$value];

        return null;
    }

    public function add(Node $node): void
    {
        if (key_exists($node->getValue(), $this->nodes)) return;

        $this->nodes[$node->getValue()] = $node;
    }
}
