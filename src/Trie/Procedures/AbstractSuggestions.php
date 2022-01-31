<?php

namespace Sjokkateer\Trie\Procedures;

use Sjokkateer\Trie\Node;
use Sjokkateer\Trie\TerminationNode;

abstract class AbstractSuggestions implements ProcedureInterface
{
    protected function suggest(Node $current, string $subStr, array &$result): void
    {
        if ($current instanceof TerminationNode) {
            $result[] = $subStr;
        }

        foreach ($current->getNodes() as $child) {
            $this->suggest($child, $subStr . $child->getValue(), $result);
        }
    }
}
