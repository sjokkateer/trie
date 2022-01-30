# Trie
## Usage
The usage example is based on [BetterTTV](https://betterttv.com/) emotes, through which each emote available for a particular channel is added to the trie. A client can then obtain suggestions for a particular prefix much like an auto complete feature.

A different use case could be a directory with files, each file in the directory gets added to a trie and suggestions are obtained for a file starting with some prefix.

The example would look as follows in code:
```php
$trie = new Trie;
$words = ['Okay', 'Okayeg', 'OkayChamp', 'docPls', 'docnotL'];
$trie->addWords($words);
```
This will add each `$word` in `$words` to `$trie` accordingly.

Or when the user wants to add an individual word:
```php
$trie->addWord('doctorKick');
```

`$trie` should look like the trie in the image (not part of the library). Where each termination node is represented by a double circle with a red color, indicating the termination point for a sequence of characters and thus an existing word.

<p align="center">
  <img src="https://github.com/sjokkateer/trie/blob/main/example_trie.png" />
</p>

Asking the trie for suggestions for a particular prefix:
```php
$suggestions = $trie->suggestionsFor('doc');
```
`$suggestions` will now hold the following words:
```php
(
    [0] => docPls
    [1] => docnotL
    [2] => doctorKick
)
```
The `Trie::suggestionsFor` method is case sensitive by default. Thus, asking for suggestions for `'okay'` on the example results in an empty array:
```php
(
)
```
To apply case insensitive search a boolean flag can be given as second argument to the method:
```php
$suggestions = $trie->suggestionsFor('okay', Mode::CASE_INSENSITIVE);
```
`$suggestions` will now hold the following words:
```php
(
    [0] => Okay
    [1] => Okayeg
    [2] => OkayChamp
)
```
Thus, all words starting with `'okay'`, whether characters are upper or lower cased.

The user can also test if a word exists within the trie through `Trie::exists` which similarly to the other method accepts a flag for case sensitivity.

```php
$trie->exists('okayeg', Mode::CASE_INSENSITIVE);
```
Which based on the example returns `true`.
