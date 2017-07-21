<?php
// coverage-badger.php
$inputFile  = $argv[1];
$outputFile = $argv[2];

if (!file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}

$xml             = new SimpleXMLElement(file_get_contents($inputFile));
$metrics         = $xml->xpath('//metrics');
$totalElements   = 0;
$checkedElements = 0;

foreach ($metrics as $metric) {
    $totalElements   += (int) $metric['elements'];
    $checkedElements += (int) $metric['coveredelements'];
}

$coverage = (int)(($totalElements === 0) ? 0 : ($checkedElements / $totalElements) * 100);

$template = file_get_contents(__DIR__ . '/templates/flat.svg');

$template = str_replace('{{ total }}', $coverage, $template);

file_put_contents($outputFile, $template);
