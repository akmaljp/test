<?php

include __DIR__ . '/../../vendor/autoload.php';

use akmaljp\DriveMaru\Bundles\Forum as DriveMaru;

$text = '[url="javascript://example.org/%0Aalert(1)"]xss[/url]';
$xml  = DriveMaru::parse($text);
$html = DriveMaru::render($xml);

echo $html, "\n";

// Outputs:
//
// [url="javascript://example.org/%0Aalert(1)"]xss[/url]
