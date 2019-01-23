<h2>Automatic rules generation</h2>

Automatic rules generation is performed by `$configurator->rulesGenerator`, which you can access as an array.

See [Rules generators](Rules_generators.md) for a description of rules generators.

```php
$configurator = new akmaljp\DriveMaru\Configurator;

foreach ($configurator->rulesGenerator as $i => $generator)
{
	echo $i, "\t", get_class($generator), "\n";
}
```
```
0	akmaljp\DriveMaru\Configurator\RulesGenerators\AutoCloseIfVoid
1	akmaljp\DriveMaru\Configurator\RulesGenerators\AutoReopenFormattingElements
2	akmaljp\DriveMaru\Configurator\RulesGenerators\BlockElementsCloseFormattingElements
3	akmaljp\DriveMaru\Configurator\RulesGenerators\BlockElementsFosterFormattingElements
4	akmaljp\DriveMaru\Configurator\RulesGenerators\DisableAutoLineBreaksIfNewLinesArePreserved
5	akmaljp\DriveMaru\Configurator\RulesGenerators\EnforceContentModels
6	akmaljp\DriveMaru\Configurator\RulesGenerators\EnforceOptionalEndTags
7	akmaljp\DriveMaru\Configurator\RulesGenerators\IgnoreTagsInCode
8	akmaljp\DriveMaru\Configurator\RulesGenerators\IgnoreTextIfDisallowed
9	akmaljp\DriveMaru\Configurator\RulesGenerators\IgnoreWhitespaceAroundBlockElements
10	akmaljp\DriveMaru\Configurator\RulesGenerators\TrimFirstLineInCodeBlocks
```

### Remove a generator

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->rulesGenerator->remove('IgnoreTextIfDisallowed');
```

### Add a default generator

To add the `ManageParagraphs` generator:
```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->rulesGenerator->add('ManageParagraphs');
```
