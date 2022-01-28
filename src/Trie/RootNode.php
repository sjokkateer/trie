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

    public function getNode(string $value, bool $caseSensitive = true): ?Node
    {
        $fn = static fn (string $val, string $other): bool => $val == $other;

        if ($caseSensitive == false) {
            $fn = static fn (string $val, string $other): bool => strtolower($val) == strtolower($other);
        }

        foreach ($this->getNodes() as $node) {
            if ($fn($node->getValue(), $value)) return $node;
        }

        return null;
    }

    public function add(Node $node)
    {
        if (!key_exists($node->getValue(), $this->nodes)) {
            $this->nodes[strtolower($node->getValue())] = $node;
        }
    }
}
