<?php

namespace Sjokkateer\Trie\Procedures;

use Sjokkateer\Trie\RootNode;
use Sjokkateer\Trie\Trie;

class CaseInsensitive extends AbstractSuggestions
{
    public function __invoke(string $prefix, Trie $trie): array
    {
        $subPrefixes = $this->getSubPrefixes($prefix, $trie->getRoot());
        $result = [];

        foreach ($subPrefixes as $subPrefix => $node) {
            $this->suggest($node, $subPrefix, $result);
        }

        return $result;
    }

    private function getSubPrefixes(string $prefix, RootNode $root): array
    {
        $subPrefixes = ['' => $root];

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
}
