## Introduction

akmaljp\DriveMaru can optionally generate a JavaScript parser that can be used in browsers to parse text and preview the result in a live environment. The JavaScript parser requires Internet Explorer 8 or later, or any contemporary browser that supports [XSLTProcessor](https://developer.mozilla.org/en-US/docs/Web/API/XSLTProcessor#Browser_compatibility).

```php
$configurator = new akmaljp\DriveMaru\Configurator;

// Enable the JavaScript parser
$configurator->enableJavaScript();

// Now finalize() will return an entry for "js"
extract($configurator->finalize());
```

With JavaScript enabled, `finalize()` will return an element named `js` that contains the JavaScript source for the `akmaljp.DriveMaru` JavaScript object.

### API

```js
// Parse $text and return the XML as a string
akmaljp.DriveMaru.parse($text);

// Parse $text and preview it in HTMLElement $target. It will return the last node modified
akmaljp.DriveMaru.preview($text, $target);

// Toggle a plugin by name
akmaljp.DriveMaru.disablePlugin($pluginName);
akmaljp.DriveMaru.enablePlugin($pluginName);

// Toggle a tag by name
akmaljp.DriveMaru.disableTag($tagName);
akmaljp.DriveMaru.enableTag($tagName);

// Runtime configuration
akmaljp.DriveMaru.setNestingLimit($tagName, $limit);
akmaljp.DriveMaru.setTagLimit($tagName, $limit);
```

### Minify the JavaScript parser with the Google Closure Compiler service

The JavaScript parser can be automatically be minified using the [Google Closure Compiler service](https://developers.google.com/closure/compiler/docs/gettingstarted_api) via HTTP. The minification level and other configuration are automatically set.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();
$configurator->javascript->setMinifier('ClosureCompilerService');
```

[Other minifiers are available.](Minifiers.md)

### Speed up minification with a cache

The result of minification can be cached locally and reused. It's only useful if the JavaScript parser is regenerated more often than the configuration changes, since any modification to the configuration produces a different source.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();

$configurator->javascript
	->setMinifier('ClosureCompilerService')
	->cacheDir = '/path/to/cache';
```

### Improve minification

It is possible to improve the minification ratio by disabling features that are not used. For instance, if you only use the `parse` and `preview` methods you can reduce the API to only those two methods.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();

$configurator->javascript->exports = [
	'parse',
	'preview'
];
```
