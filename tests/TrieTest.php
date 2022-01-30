<?php

use Sjokkateer\Trie\Trie;
use PHPUnit\Framework\TestCase;

final class TrieTest extends TestCase
{
    private Trie $trie;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trie = new Trie;
    }

    public function testCaseSensitiveSuggestionsForGivenExistingPrefixAndCaseSensitiveExpectedMultipleSuggestionsReturned(): void
    {
        $wordsStartingWithOkay = ['Okay', 'Okayeg', 'OkayChamp', 'OkayChamps', 'OkayChampions', 'OkayDude'];
        $nonMatchingWords = ['Some', 'Garbage'];

        $this->trie->addWords([...$wordsStartingWithOkay, ...$nonMatchingWords]);

        $actualSuggestions = $this->trie->caseSensitiveSuggestionsFor('Okay');
        $expectedSuggestions = $wordsStartingWithOkay;

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testCaseInsensitiveSuggestionsForGivenExistingPrefixAndCaseInsensitiveExpectedSingleSuggestionReturned(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $this->trie->addWords([$wordTwo, $wordOne]);

        $actualSuggestions = $this->trie->caseInsensitiveSuggestionsFor('okayc');
        $expectedSuggestions = [$wordTwo];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testCaseInsensitiveSuggestionsForGivenExistingPrefixAndCaseInsensitiveAllSamePrefixExpectedAllReturned(): void
    {
        $words = ['Okayeg', 'oKaYeg', 'OkayeG', 'OKAYEG', 'okayeg'];

        $this->trie->addWords($words);

        $actualSuggestions = $this->trie->caseInsensitiveSuggestionsFor('okayeg');

        foreach ($words as $word) {
            $this->assertContains($word, $actualSuggestions);
        }
    }

    /** @dataProvider nonExistingPrefixes */
    public function testCaseSensitiveSuggestionsForGivenNonExistingPrefixAndCaseSensitiveExpectedNoSuggestionsReturned(string $nonExistingPrefix): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $this->trie->addWords([$wordOne, $wordTwo]);

        $actualSuggestions = $this->trie->caseSensitiveSuggestionsFor($nonExistingPrefix);
        $expectedSuggestions = [];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function nonExistingPrefixes(): array
    {
        return [
            'Empty string' => [''],
            'Prefix not existing' => ['Some'],
            'Prefix longer than existing word' => ['OkayChampions'],
        ];
    }

    /** @dataProvider nonExistingPrefixes */
    public function testCaseInsensitiveSuggestionsForGivenNonExistingPrefixAndCaseSensitiveExpectedNoSuggestionsReturned(string $nonExistingPrefix): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $this->trie->addWords([$wordOne, $wordTwo]);

        $actualSuggestions = $this->trie->caseInsensitiveSuggestionsFor($nonExistingPrefix);
        $expectedSuggestions = [];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testExistsGivenAnExistingWordExpectedTrueReturned(): void
    {
        $existingWord = 'Okayeg';
        $this->trie->addWords([$existingWord, 'OkayChamp']);

        $exists = $this->trie->exists($existingWord);

        $this->assertTrue($exists);
    }

    public function testExistsGivenANonExistingWordExpectedFalseReturned(): void
    {
        $this->trie->addWords(['Okay', 'Okayeg', 'OkayChamp']);

        $exists = $this->trie->exists('okayeg');

        $this->assertFalse($exists);
    }
}
