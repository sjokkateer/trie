<?php

namespace Sjokkateer\Trie;

abstract class NodeFactory
{
    abstract public function createRootNode(): RootNode;
    abstract public function createNode(string $value): Node;
    abstract public function createTerminationNode(string $value): TerminationNode;
}
