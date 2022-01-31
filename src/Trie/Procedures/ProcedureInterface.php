<?php

namespace Sjokkateer\Trie\Procedures;

use Sjokkateer\Trie\Trie;

interface ProcedureInterface
{
    public function __invoke(string $prefix, Trie $trie);
}
