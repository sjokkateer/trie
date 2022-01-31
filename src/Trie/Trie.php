<?php

namespace Sjokkateer\Trie;

class Trie
{
    protected NodeFactory $factory;
    protected RootNode $root;

    public function __construct(?NodeFactory $factory = null)
    {
        if ($factory === null) $factory = new DefaultFactory;

        $this->factory = $factory;
        $this->root = $this->factory->createRootNode();
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

        $current = $this->getRoot();

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
        if ($isLastIndex) return $this->factory->createTerminationNode($value);

        return $this->factory->createNode($value);
    }
}
