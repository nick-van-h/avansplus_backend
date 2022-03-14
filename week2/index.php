<?php

//For debugging
ini_set("display_errors", 1);

//Include our functions file
require_once 'functions.php';

/**
 * Get the sentences from the file
 * Loop through each sentence
 * Process the sentence accordingly
 * Output the result
 */


echo '<h2>Week 2 assignment</h2><hr>';
$sentences = get_sentences();
foreach ($sentences as $key => $sentence) {

    $normalizedSentence = normalize_sentence($sentence);
    $substitutedSentence = substitute_sentence($normalizedSentence);
    $truncateLength = rand(50, 125);
    $truncatedSentence = truncate_sentence($substitutedSentence, $truncateLength);
    $nrSwearwords = count_number_of_bad_words($sentence, true);
    $nrNegativeWords = count_number_of_bad_words($sentence, false);
    $nrNormalizedLetters = count_normalized_letters($sentence);
    $nrReplacedWords = count_total_corrected_words($sentence, $substitutedSentence);
    $totalNrWords = count_total_words($substitutedSentence);
    $percentageReplacedWords = floor(($nrReplacedWords / $totalNrWords) * 1000) / 10;

    echo '<pre>';
    echo '<h3>Sentence #' . ($key + 1) . '</h3>';
    echo 'Original sentence: ' . $sentence . '<br>';
    echo 'Normalized proper sentence: ' . $substitutedSentence . '<br>';
    echo 'Truncated to ' . $truncateLength . ' characters: ' . $truncatedSentence . '<br>';

    echo '<h3>Stats</h3>';
    echo '# of swearwords: ' . $nrSwearwords . '<br>';
    echo '# of negative words: ' . $nrNegativeWords . '<br>';
    echo '# of corrected capitals: ' . $nrNormalizedLetters . '<br>';
    echo '# of replaced words (any): ' . $nrReplacedWords . '<br>';
    echo 'Total # of words: ' . $totalNrWords . '<br>';
    echo '% of words replaced: ' . $percentageReplacedWords . '%<br>';
    echo '</pre>';
    echo '<hr>';
}

/**
 * Known open issues for further improvement
 */
echo '<h3>Open issues</h3>';
echo '<ul>';
echo '<li>Capitalized bad words are recognized but not replaced --> Due to case sensitive str_replace</li>';
echo '<ul>';
echo '<li>To determine the bad words the sentence is converted to lower case first</li>';
echo '<li>This is required to perform array_intersect with the bad word dictionary</li>';
echo '<li>For example: The sentence contains "Gluiperd" while the array contains "gluiperd"</li>';
echo '<li>Since str_replace is case sensitive, this word is not replaced</li>';
echo '</ul>';
echo '<li>Replacing multiple consecutive negative words can result in repeating positive words --> Due to random select from dictionary';
echo '<ul>';
echo '<li>For example: "Hij speelde bedrieglijk en oneerlijk"</li>';
echo '<li>Both "bedrieglijk" and "oneerlijk" are recognized as bad words</li>';
echo '<li>For each bad word a random good word is selected</li>';
echo '<li>This might result in e.g.: "Hij speelde oprecht en oprecht"</li>';
echo '</ul>';
echo '</li>';
echo '</ul>';
