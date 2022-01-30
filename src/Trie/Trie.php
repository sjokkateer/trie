<?php

namespace Sjokkateer\Trie;

class Trie
{
    protected RootNode $root;

    public function __construct()
    {
        $this->root = new RootNode;
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

    public function caseSensitiveSuggestionsFor(string $prefix): array
    {
        $current = $this->root;
        $str = '';
        $result = [];

        foreach (str_split($prefix) as $c) {
            $current = $current->getNode($c);

            if ($current === null) return $result;

            $str .= $current->getValue();
        }

        $this->suggest($current, $prefix, $result);

        return $result;
    }

    private function suggest(Node $current, string $subStr, array &$result): void
    {
        if ($current instanceof TerminationNode) {
            $result[] = $subStr;
        }

        foreach ($current->getNodes() as $child) {
            $this->suggest($child, $subStr . $child->getValue(), $result);
        }
    }

    public function caseInsensitiveSuggestionsFor(string $prefix): array
    {
        $subPrefixes = $this->getSubPrefixes($prefix);
        $result = [];

        foreach ($subPrefixes as $subPrefix => $node) {
            $this->suggest($node, $subPrefix, $result);
        }

        return $result;
    }

    private function getSubPrefixes(string $prefix): array
    {
        $subPrefixes = ['' => $this->root];

        foreach (str_split($prefix) as $c) {
            $lower = strtolower($c);
            $upper = strtoupper($c);

            foreach ($subPrefixes as $subPrefix => $current) {
                unset($subPrefixes[$subPrefix]);

                $lowerNode = $current->getNode($lower);
                $upperNode = $current->getNode($upper);

                foreach ([$lowerNode, $upperNode] as $node) {
                    if ($node === null) continue;

                    $subPrefixes[$subPrefix . $node->getValue()] = $node;
                }
            }
        }

        return $subPrefixes;
    }

    public function exists(string $word): bool
    {
        $strlen = strlen($word);
        $lastIndex = $strlen - 1;

        $current = $this->root;

        for ($i = 0; $i < $strlen; $i++) {
            $current = $current->getNode($word[$i]);

            if ($current === null) break;

            if ($i == $lastIndex && $current instanceof TerminationNode) return true;
        }

        return false;
    }
}
