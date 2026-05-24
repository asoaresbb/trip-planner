<?php

$name = 'Andre';
$age = 25;
$isFather = true;
$money = 19.00;
$salary = null;

echo $name;
echo '<br> Hello ' . $name . '!<br>';
echo "Hello {$name}! <br>";
echo $age . '<br>';
echo $isFather . '<br>';
echo $money . '<br>';
echo $salary . '<br>';

echo gettype($name) . '<br>';