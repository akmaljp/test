<?php

// Get the autoloader
include __DIR__ . '/../../vendor/autoload.php';

// Use the Forum bundle. It supports BBCodes, emoticons and autolinking
use akmaljp\DriveMaru\Bundles\Forum as DriveMaru;

// Original text
$text = "Hello, [i]world[/i] :)\nFind more examples in the [url=https://akmaljpDriveMaru.readthedocs.io/]documentation[/url].";

// XML representation, that's what you should store in your database
$xml  = DriveMaru::parse($text);

// HTML rendering, that's what you display to the user
$html = DriveMaru::render($xml);

echo $html, "\n";

// Outputs:
//
// Hello, <i>world</i> <img alt=":)" class="emoji" draggable="false" src="//cdn.jsdelivr.net/emojione/assets/4.0/png/64/1f642.png"><br>
// Find more examples in the <a href="https://akmaljpDriveMaru.readthedocs.io/">documentation</a>.
