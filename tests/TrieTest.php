<?php

use Sjokkateer\Trie\Trie;
use PHPUnit\Framework\TestCase;

final class TrieTest extends TestCase
{
    public function testWordSuggestionsCaseSensitive(): void
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

    public function testWordSuggestionsCaseInsensitive(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';
        $trie = new Trie;

        $trie->addWord($wordOne);
        $trie->addWord($wordTwo);

        $actualSuggestions = $trie->suggestionsFor('okayc', false);
        $expectedSuggestions = [$wordTwo];

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
        $trie = new Trie;
        $trie->addWords(['Okayeg', 'OkayChamp']);

        $actualSuggestions = $trie->suggestionsFor('OkayChampions');
        $expectedSuggestions = [];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testExistsOnExistingWordExpectedTrueReturned(): void
    {
        $trie = new Trie;
        $word = 'Okayeg';
        $trie->addWords([$word, 'OkayChamp']);

        $exists = $trie->exists($word);

        $this->assertTrue($exists);
    }

    public function testExistsOnNonExistingWordExpectedFalseReturned(): void
    {
        $trie = new Trie;
        $trie->addWords(['Okayeg', 'OkayChamp']);

        $exists = $trie->exists('SomeOtherString');

        $this->assertFalse($exists);
    }

    public function testExistsGivenCaseInsensitiveOnExistingWordExpectedTrueReturned(): void
    {
        $trie = new Trie;
        $trie->addWords(['Okayeg', 'OkayChamp']);

        $exists = $trie->exists('okayeg', false);

        $this->assertTrue($exists);
    }
}
