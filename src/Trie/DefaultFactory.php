<?php

namespace Sjokkateer\Trie;

class DefaultFactory extends NodeFactory
{
    public function createRootNode(): RootNode
    {
        return new RootNode;
    }

    public function createNode(string $value): Node
    {
        return new Node($value);
    }

    public function createTerminationNode(string $value): TerminationNode
    {
        return new TerminationNode($value);
    }
}
