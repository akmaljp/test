<h2>Minifiers</h2>

Several minifiers are available. Minification can take several seconds so it is recommended to [set up a cache directory](Introduction.md#speed-up-minification-with-a-cache).

### Google Closure Compiler service

This is the best choice for most users. The Closure Compiler service is [hosted by Google](https://developers.google.com/closure/compiler/docs/terms_ui?csw=1) and is accessible via HTTP. The default configuration gives the best results.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();
$configurator->javascript->setMinifier('ClosureCompilerService');
```

### Google Closure Compiler application

Alternatively, the [Google Closure Compiler application](https://developers.google.com/closure/compiler/docs/gettingstarted_app) can be used. This requires PHP to be able to use `exec()` to execute the relevant executables. Like the Google Closure Compiler service, configuration is automatic.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();

// Deprecated usage
$configurator->javascript
	->setMinifier('ClosureCompilerApplication')
	->closureCompilerBin = '/usr/local/bin/compiler.jar';

// Recommended usage (1.3.0 and newer)
$configurator->javascript
	->setMinifier('ClosureCompilerApplication')
	->command = 'java -jar /usr/local/bin/compiler.jar';

// You can use npx or a native executable
$configurator->javascript
	->setMinifier('ClosureCompilerApplication')
	->command = 'npx google-closure-compiler';

// Short syntax
$configurator->javascript
	->setMinifier('ClosureCompilerApplication', 'npx google-closure-compiler');
```

### MatthiasMullie\\Minify

[Minify](https://www.minifier.org/) is a JavaScript minifier written in PHP. Its minification is not as extensive as Google's Closure Compiler but it is fast and does not use any external service. In order to use this minifier you must have Minify already installed.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();
$configurator->javascript->setMinifier('MatthiasMullieMinify');
```

## Meta-minifiers

### Noop

As the name implies, the no-op minifier will preserve the original source as-is. This is the default setting.

### FirstAvailable

The FirstAvailable strategy allows multiple minifiers to be set. They are executed in order and the result of the first successful minification is returned.

In the following example, we set up the ClosureCompilerService minifier to handle minification. If it fails, the MatthiasMullieMinify minifier will be executed. If it fails too, the Noop (no-op) minifier is executed as a fail-safe and the original source is returned.

```php
$configurator = new akmaljp\DriveMaru\Configurator;
$configurator->enableJavaScript();

$minifier = $configurator->javascript->setMinifier('FirstAvailable');
$minifier->add('ClosureCompilerService');
$minifier->add('MatthiasMullieMinify');
$minifier->add('Noop');
```
