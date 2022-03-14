<?php

/**
 * Read the dictionary json file and return as array
 */
function get_dictionary()
{
    return json_decode(file_get_contents('dictionary.json'), true);
}


/**
 * Read the sentences json file and return as array
 */
function get_sentences()
{
    return json_decode(file_get_contents('sentences.json'), true);
}

/**
 * Substitute all bad words in a sentence
 * First substitute all swearwords
 * Next substitute all negative words
 * Returns the complete substituted sentence
 */
function substitute_sentence($sentence): string
{
    $sentence = sub_substitute_sentence($sentence, false);
    $sentence = sub_substitute_sentence($sentence, true);
    return $sentence;
}

/**
 * Counts the total number of words that have been corrected
 * Either words that have been converted to capitals
 * Or bad words that have been replaced by good words
 */
function count_total_corrected_words($originalSentence, $compareSentence): int
{
    $orgArr = explode(" ", preg_replace('/[^A-Za-z0-9 ]/', '', $originalSentence));
    $compArr = explode(" ", preg_replace('/[^A-Za-z0-9 ]/', '', $compareSentence));
    $diff = array_diff($compArr, $orgArr);
    return count($diff);
}

function count_total_words($sentence): int
{
    return count(explode(" ", preg_replace('/[^A-Za-z0-9 ]/', '', $sentence)));
}

/**
 * Substitute bad words in a sentence
 * Use the $swearwords selector to either substitute sweawords or negative words
 */
function sub_substitute_sentence($sentence, bool $swearwords = true): string
{
    /**
     * Generate two equal arrays of bad words and counterpart good words
     * This is required for str_replace which expects two arrays of equal length
     */
    $badWords = get_bad_words_in_sentence($sentence, $swearwords);
    $goodWords = get_random_good_words(count_number_of_bad_words($sentence, $swearwords), $swearwords);
    $str = str_replace($badWords, $goodWords, $sentence);
    return $str;
}

/**
 * Count the number of bad words in a sentence
 * Use the $swearwords selector to count either swearwords or negative words
 */
function count_number_of_bad_words($sentence, bool $swearwords = true): int
{
    return count(get_bad_words_in_sentence($sentence, $swearwords));
}

/**
 * Get an array of bad words in a sentence
 * Use the $swearwords selector to list either swearwords or negative words
 */
function get_bad_words_in_sentence($sentence, bool $swearwords = true): array
{
    /**
     * Use array_intersect to determine the overlap between bad words in the dictionary and words used in the sentence
     * Dictionary contains only words in lower case, use get_clean_array_from_string to convert the sentence
     * to an array containing only lower case words without special characters 
     */
    $data = get_dictionary();
    $sentenceArray = get_clean_array_from_string($sentence);
    $badWords = $swearwords ? $data['swearwords'] : $data['negative_words'];
    $arr = array_intersect($sentenceArray, $badWords);
    return $arr;
}

/**
 * Returns an array of specified count with good words
 * Use the $swearwords selector to generate alterntives for either swearwords or negative words
 */
function get_random_good_words($count, bool $swearwords = true): array
{
    $data = get_dictionary();
    $substitutes = $swearwords ? $data['swearword_substitutes'] : $data['negative_word_substitutes'];
    $arrLen = count($substitutes);
    $arr = [];
    for ($i = 0; $i < $count; $i++) {
        $arr[] = $substitutes[rand(0, $arrLen - 1)];
    }
    return $arr;
}

/**
 * Returns an array of lower case words in the given sentence
 * Special characters and spaces are omitted
 */
function get_clean_array_from_string($sentence): array
{
    return explode(" ", strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $sentence)));
}

/**
 * Converts the first letter in a sentence to upper case
 */
function normalize_sentence($sentence): string
{
    return uc_sentence($sentence, false);
}

/**
 * Counts the number of times the first letter in the sentence is converted to upper case
 */
function count_normalized_letters($sentence): int
{
    return uc_sentence($sentence, true);
}

/**
 * Process the sentence for upper case
 * Based on the $count selector return the count of how much letters have been converted to upper case
 * or return the corrected sentence
 */
function uc_sentence($sentence, bool $count = false)
{
    /**
     * Use regex to determine sentence end; either dot, question mark or exclamation point
     * Loop through the resulting array, convert first character to upper case
     * and concatenate to the resulting string
     */
    preg_match_all('/[(. )(? )(! )]|[^.?!]*/', $sentence, $arr);
    $res = '';
    $ttl = 0;
    foreach ($arr[0] as $part) {
        $res .= ucfirst($part);
        if ($part != ucfirst($part)) {
            $ttl += 1;
        }
    }
    if ($count) {
        return $ttl;
    } else {
        return $res;
    }
}

/**
 * Truncates the sentence to a given length
 * If the given length is 0 or less, or if the given length exceeds the total length of the sentence,
 * then the sentence is not truncated and the full sentence is returned
 */
function truncate_sentence($sentence, $length = 0): string
{
    if ($length <= 0 || (strlen($sentence) < $length)) {
        return $sentence;
    } else {
        return (substr($sentence, 0, $length) . '...');
    }
}
