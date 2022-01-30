<?php

use Sjokkateer\Trie\Trie;
use PHPUnit\Framework\TestCase;
use Sjokkateer\Trie\Mode;

final class TrieTest extends TestCase
{
    private Trie $trie;

    protected function setUp(): void
    {
        parent::setUp();
        $this->trie = new Trie;
    }

    public function testSuggestionsForGivenExistingPrefixAndCaseSensitiveExpectedMultipleSuggestionsReturned(): void
    {
        $wordsStartingWithOkay = ['Okay', 'Okayeg', 'OkayChamp', 'OkayChamps', 'OkayChampions', 'OkayDude'];
        $nonMatchingWords = ['Some', 'Garbage'];

        $this->trie->addWords([...$wordsStartingWithOkay, ...$nonMatchingWords]);

        $actualSuggestions = $this->trie->suggestionsFor('Okay');
        $expectedSuggestions = $wordsStartingWithOkay;

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    public function testSuggestionsForGivenExistingPrefixAndCaseInsensitiveExpectedSingleSuggestionReturned(): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $this->trie->addWords([$wordTwo, $wordOne]);

        $actualSuggestions = $this->trie->suggestionsFor('okayc', Mode::CASE_INSENSITIVE);
        $expectedSuggestions = [$wordTwo];

        $this->assertEquals($expectedSuggestions, $actualSuggestions);
    }

    /** @dataProvider nonExistingPrefixes */
    public function testSuggestionsForGivenNonExistingPrefixAndCaseSensitiveExpectedNoSuggestionsReturned(string $nonExistingPrefix): void
    {
        $wordOne = 'Okayeg';
        $wordTwo = 'OkayChamp';

        $this->trie->addWords([$wordOne, $wordTwo]);

        $actualSuggestions = $this->trie->suggestionsFor($nonExistingPrefix);
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

    public function testExistsGivenAnExistingWordExpectedTrueReturned(): void
    {
        $existingWord = 'Okayeg';
        $this->trie->addWords([$existingWord, 'OkayChamp']);

        $exists = $this->trie->exists($existingWord);

        $this->assertTrue($exists);
    }

    public function testExistsGivenANonExistingWordExpectedFalseReturned(): void
    {
        $this->trie->addWords(['Okayeg', 'OkayChamp']);

        $exists = $this->trie->exists('SomeOtherString');

        $this->assertFalse($exists);
    }

    public function testExistsGivenAnExistingWordAndCaseInsensitiveExpectedTrueReturned(): void
    {
        $existingWord = 'Okayeg';
        $this->trie->addWords([$existingWord, 'OkayChamp']);

        $exists = $this->trie->exists(strtolower($existingWord), Mode::CASE_INSENSITIVE);

        $this->assertTrue($exists);
    }
}
