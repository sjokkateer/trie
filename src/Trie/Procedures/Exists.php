<?php

namespace Sjokkateer\Trie\Procedures;

use Sjokkateer\Trie\TerminationNode;
use Sjokkateer\Trie\Trie;

class Exists implements ProcedureInterface
{
    public function __invoke(string $prefix, Trie $trie): bool
    {
        $strlen = strlen($prefix);
        $lastIndex = $strlen - 1;

        $current = $trie->getRoot();

        for ($i = 0; $i < $strlen; $i++) {
            $current = $current->getNode($prefix[$i]);

            if ($current === null) break;

            if ($i == $lastIndex && $current instanceof TerminationNode) return true;
        }

        return false;
    }
}
