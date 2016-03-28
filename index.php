<?php
include 'vendor/autoload.php';

use Natividad\Tagauri\Tagauri;

$trainingFile = __DIR__ . '/data/training-data.csv';

$tagauri = new Tagauri($trainingFile);
$tagauri->sanayin();
echo $tagauri->uriin('Nabangga ang sinasakyan namin');