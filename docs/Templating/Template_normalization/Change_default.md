<h2>Change the default settings</h2>

By default, template normalization consists in optimizing a template's content by removing superfluous whitespace and inlining content wherever possible, as well as normalize HTML elements' and attributes' names to lowercase and [other menial tasks](https://github.com/akmaljp/DriveMaru/tree/master/src/Configurator/TemplateNormalizations).

Template normalization is performed by `$configurator->templateNormalizer`, which you can access as an array.

```php
$configurator = new akmaljp\DriveMaru\Configurator;

foreach ($configurator->templateNormalizer as $i => $normalizer)
{
	echo $i, "\t", get_class($normalizer), "\n";
}
```
```
0	akmaljp\DriveMaru\Configurator\TemplateNormalizations\PreserveSingleSpaces
1	akmaljp\DriveMaru\Configurator\TemplateNormalizations\RemoveComments
2	akmaljp\DriveMaru\Configurator\TemplateNormalizations\RemoveInterElementWhitespace
3	akmaljp\DriveMaru\Configurator\TemplateNormalizations\FixUnescapedCurlyBracesInHtmlAttributes
4	akmaljp\DriveMaru\Configurator\TemplateNormalizations\UninlineAttributes
5	akmaljp\DriveMaru\Configurator\TemplateNormalizations\EnforceHTMLOmittedEndTags
6	akmaljp\DriveMaru\Configurator\TemplateNormalizations\FoldArithmeticConstants
7	akmaljp\DriveMaru\Configurator\TemplateNormalizations\FoldConstantXPathExpressions
8	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineCDATA
9	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineElements
10	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineTextElements
11	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineXPathLiterals
12	akmaljp\DriveMaru\Configurator\TemplateNormalizations\MinifyXPathExpressions
13	akmaljp\DriveMaru\Configurator\TemplateNormalizations\NormalizeAttributeNames
14	akmaljp\DriveMaru\Configurator\TemplateNormalizations\NormalizeElementNames
15	akmaljp\DriveMaru\Configurator\TemplateNormalizations\NormalizeUrls
16	akmaljp\DriveMaru\Configurator\TemplateNormalizations\OptimizeConditionalAttributes
17	akmaljp\DriveMaru\Configurator\TemplateNormalizations\OptimizeConditionalValueOf
18	akmaljp\DriveMaru\Configurator\TemplateNormalizations\OptimizeChoose
19	akmaljp\DriveMaru\Configurator\TemplateNormalizations\OptimizeChooseText
20	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineAttributes
21	akmaljp\DriveMaru\Configurator\TemplateNormalizations\InlineInferredValues
22	akmaljp\DriveMaru\Configurator\TemplateNormalizations\SetRelNoreferrerOnTargetedLinks
23	akmaljp\DriveMaru\Configurator\TemplateNormalizations\MinifyInlineCSS
```

### Remove a normalization

```php
$configurator = new akmaljp\DriveMaru\Configurator;

echo $configurator->templateNormalizer->normalizeTemplate('<![CDATA[ Will be inlined ]]>'), "\n";

$configurator->templateNormalizer->remove('InlineCDATA');

echo $configurator->templateNormalizer->normalizeTemplate('<![CDATA[ Will not be inlined ]]>');
```
```html
 Will be inlined 
<![CDATA[ Will not be inlined ]]>
```

### Add your own custom normalization

You can `append()` or `prepend()` a callback to the template normalizer. It will be called with one argument, a `DOMNode` that represents the `<xsl:template/>` element that contains the template, which you can modify normally. At the end, the node is serialized back to XML. The template normalizer iterates through the list of normalizations up to 5 times, until none of them modifies the template. If you set `onlyOnce` to true, the normalization will only be applied during the first loop.

```php
$configurator = new akmaljp\DriveMaru\Configurator;

// Add a callback that adds a "?" to the template and that is executed only once
$configurator->templateNormalizer->append(
	function (DOMNode $template)
	{
		$template->appendChild($template->ownerDocument->createTextNode('?'));
	}
)->onlyOnce = true;

// Add a callback that adds a "!" to the template
$configurator->templateNormalizer->append(
	function (DOMNode $template)
	{
		$template->appendChild($template->ownerDocument->createTextNode('!'));
	}
);

echo $configurator->templateNormalizer->normalizeTemplate('Hello world');
```
```html
Hello world?!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
```
