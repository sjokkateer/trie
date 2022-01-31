<?php

namespace Sjokkateer\Trie\Procedures;

use Sjokkateer\Trie\Trie;

class CaseSensitive extends AbstractSuggestions
{
    public function __invoke(string $prefix, Trie $trie): array
    {
        $current = $trie->getRoot();
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
}
