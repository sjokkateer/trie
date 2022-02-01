<?php

namespace Sjokkateer\Trie;

abstract class NodeFactory
{
    public function createRootNode(): RootNode
    {
        return new RootNode;
    }

    abstract public function createNode(string $value): Node;
    abstract public function createTerminationNode(string $value): TerminationNode;
}
