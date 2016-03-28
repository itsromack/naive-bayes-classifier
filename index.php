<?php
include 'vendor/autoload.php';

use Fieg\Bayes\Classifier;
use Fieg\Bayes\Tokenizer\WhitespaceAndPunctuationTokenizer;
use Keboola\Csv\CsvFile;

$trainingFile = __DIR__ . '/data/training-data.csv';

$tokenizer = new WhitespaceAndPunctuationTokenizer();
$classifier = new Classifier($tokenizer);
$rows = new CsvFile($trainingFile);

foreach ($rows as $row) {
	$category = $row[0];
	$data = $row[1];
	$classifier->train($category, $data);
	echo $category . ':' . $data ."\n";
}

$guess = 'binangga po ang sasakyan namin';
echo $guess . "\n";
$result = $classifier->classify($guess);

var_dump($result);