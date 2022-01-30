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

    public function getNode(string $value, int $mode = Mode::CASE_SENSITIVE): ?Node
    {
        if (key_exists($value, $this->nodes)) return $this->nodes[$value];
        if ($mode == Mode::CASE_INSENSITIVE) {
            $other = ctype_lower($value) ? strtoupper($value) : strtolower($value);
            if (key_exists($other, $this->nodes)) return $this->nodes[$other];
        }

        return null;
    }

    public function add(Node $node): void
    {
        if (key_exists($node->getValue(), $this->nodes)) return;

        $this->nodes[$node->getValue()] = $node;
    }
}
