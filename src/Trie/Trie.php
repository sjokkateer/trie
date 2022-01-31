<?php

namespace Sjokkateer\Trie;

class Trie
{
    protected RootNode $root;

    public function __construct()
    {
        $this->root = new RootNode;
    }

    public function getRoot(): RootNode
    {
        return $this->root;
    }

    public function addWords(array $words): void
    {
        foreach ($words as $word) {
            $this->addWord($word);
        }
    }

    public function addWord(string $word): void
    {
        $strlen = strlen($word);
        $lastIndex = $strlen - 1;

        $current = $this->root;

        for ($i = 0; $i < $strlen; $i++) {
            $char = $word[$i];

            $node = $current->getNode($char);
            if ($node === null) $node = $this->createNewNode($char, $i == $lastIndex);

            $current->add($node);
            $current = $node;
        }
    }

    private function createNewNode(string $value, bool $isLastIndex): Node
    {
        $class = Node::class;
        if ($isLastIndex) $class = TerminationNode::class;

        return new $class($value);
    }
}
