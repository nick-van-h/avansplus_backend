<?php

/**
 * Test code to demistify array_diff
 */

echo '<h2>Test case: array_diff</h2>';

echo '<pre>';
echo '<b>Test case 1</b><br>';
$arr1 = array("foo", "bar", "baz");
$arr2 = array("Foo", "bar", "baz");
$diff = array_diff($arr1, $arr2);
echo 'Test array 1:<br>';
print_r($arr1);
echo 'Test array 2:<br>';
print_r($arr2);
echo 'Test array difference:<br>';
print_r($diff);
echo 'Expected outcome: foo->Foo<br><br>';

echo '<b>Test case 2</b><br>';
$str1 = "Vanochtend ben ik aangereden door een eikel! door deze klojo kwam ik te laat op mijn werk en mijn baas reageerde chagrijnig.";
$str2 = "Vanochtend ben ik aangereden door een koning! Door deze bikkel kwam ik te laat op mijn werk en mijn baas reageerde medelevend.";
$strArr1 = explode(" ", preg_replace('/[^A-Za-z0-9 ]/', '', $str1));
$strArr2 = explode(" ", preg_replace('/[^A-Za-z0-9 ]/', '', $str2));
$strDiff = array_diff($strArr1, $strArr2);
$strDiff2 = array_diff($strArr2, $strArr1);

echo 'String 1: ' . $str1 . '<br>';
echo 'String 2: ' . $str2 . '<br>';
echo 'Test string to array 1:<br>';
print_r($strArr1);
echo 'Test string to array 2:<br>';
print_r($strArr2);
echo 'Sentence difference arr1 vs arr2:<br>';
print_r($strDiff);
echo 'Sentence difference arr2 vs arr1:<br>';
print_r($strDiff2);
echo 'Expected outcome: eikel->koning, door->Door, klojo->bikkel, chagrijnig->medelevend<br><br>';

echo '</pre>';
