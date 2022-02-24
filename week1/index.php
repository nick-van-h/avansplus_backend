<?php

//Define limits
const UNDERWEIGHT_UPPER_LIMIT = 18.5;
const OVERWEIGHT_LOWER_LIMIT = 25;
const OBESITAS_LOWER_LIMIT = 30;

//Define values for the related properties
$props = array("weight" => 84, "length" => 1.808);

//Calculate BMI
$bmi = $props["weight"] / pow($props["length"], 2);
$bmi_rounded = round($bmi, 2);

//Determine weight class
if ($bmi < UNDERWEIGHT_UPPER_LIMIT) {
    $weight_class = "Underweight";
} else if ($bmi < OVERWEIGHT_LOWER_LIMIT) {
    $weight_class = "Normal weight";
} else if ($bmi < OBESITAS_LOWER_LIMIT) {
    $weight_class = "Overweight";
} else {
    $weight_class = "Obesity";
}
echo "Person X with weight {$props["weight"]}kg and length {$props["length"]}m has a BMI of {$bmi_rounded}, which is classified as {$weight_class}";
