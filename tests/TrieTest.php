<?php

use Sjokkateer\Trie\Trie;
use PHPUnit\Framework\TestCase;

final class TrieTest extends TestCase
{
    public function testWordSuggestions(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';
        $trie = new Trie;

        $trie->addWord($wordOne);
        $trie->addWord($wordTwo);

        $actualSuggestions = $trie->suggestionsFor('Okay');
        $expectedSuggestions = [$wordOne, $wordTwo];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testWordSuggestionsMultipleChildrenOfChmatchesExpectedAllSuggestionsReturned(): void
    {
        $words = ['Okay', 'Okayeg', 'OkayChamp', 'OkayChamps', 'OkayChampions', 'OkayDude'];
        $nonMatchingWords = ['Some', 'Garbage'];

        $trie = new Trie;

        foreach ([...$words, ...$nonMatchingWords] as $word) {
            $trie->addWord($word);
        }

        $actualSuggestions = $trie->suggestionsFor('Okay');
        $expectedSuggestions = $words;

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testWordSuggestionsGivenNoMatchingWordExpectedEmptyArrayReturned(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $trie = new Trie;
        $trie->addWord($wordOne);
        $trie->addWord($wordTwo);

        $actualSuggestions = $trie->suggestionsFor('Some');
        $expectedSuggestions = [];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testWordSuggestionsGivenOneMatch(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $trie = new Trie;
        $trie->addWord($wordOne);
        $trie->addWord($wordTwo);

        $actualSuggestions = $trie->suggestionsFor('OkayC');
        $expectedSuggestions = [$wordTwo];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testWordSuggestionsGivenSuperSetWordOfExistingWordExpectedNoMatchesReturned(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $trie = new Trie;
        $trie->addWord($wordOne);
        $trie->addWord($wordTwo);

        $actualSuggestions = $trie->suggestionsFor('OkayChampions');
        $expectedSuggestions = [];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }
}
