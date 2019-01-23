<?php

namespace akmaljp\DriveMaru\Tests;

use akmaljp\DriveMaru\Configurator;
use akmaljp\DriveMaru\Configurator\Items\AttributeFilter;
use akmaljp\DriveMaru\Configurator\Items\TagFilter;
use akmaljp\DriveMaru\Plugins\ConfiguratorBase;
use akmaljp\DriveMaru\Tests\Test;

/**
* @covers akmaljp\DriveMaru\Configurator
*/
class ConfiguratorTest extends Test
{
	/**
	* @testdox $configurator->attributeFilters is an instance of AttributeFilterCollection
	*/
	public function testAttributeFiltersInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Collections\\AttributeFilterCollection',
			$this->configurator->attributeFilters
		);
	}

	/**
	* @testdox $configurator->bundleGenerator is an instance of BundleGenerator
	*/
	public function testBundleGeneratorInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\BundleGenerator',
			$this->configurator->bundleGenerator
		);
	}

	/**
	* @testdox $configurator->javascript unset by default
	*/
	public function testJavaScriptDefault()
	{
		$this->assertFalse(isset($this->configurator->javascript));
	}

	/**
	* @testdox $configurator->enableJavaScript() creates an instance of JavaScript stored in $configurator->javascript
	*/
	public function testJavaScriptInstance()
	{
		$this->configurator->enableJavaScript();
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\JavaScript',
			$this->configurator->javascript
		);
	}

	/**
	* @testdox $configurator->enableJavaScript() does not overwrite the current instance of the JavaScript object
	*/
	public function testJavaScriptInstancePreserved()
	{
		$this->configurator->enableJavaScript();
		$old = $this->configurator->javascript;
		$this->configurator->enableJavaScript();
		$new = $this->configurator->javascript;

		$this->assertSame($old, $new);
	}

	/**
	* @testdox $configurator->plugins is an instance of PluginCollection
	*/
	public function testPluginsInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Collections\\PluginCollection',
			$this->configurator->plugins
		);
	}

	/**
	* @testdox $configurator->registeredVars is a publicly accessible array
	*/
	public function testRegisteredVarsVisibility()
	{
		$this->assertInternalType('array', $this->configurator->registeredVars);
	}

	/**
	* @testdox $configurator->rendering is an instance of Rendering
	*/
	public function testRenderingInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Rendering',
			$this->configurator->rendering
		);
	}

	/**
	* @testdox $configurator->rootRules is an instance of Ruleset
	*/
	public function testRootRulesInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Collections\\Ruleset',
			$this->configurator->rootRules
		);
	}

	/**
	* @testdox $configurator->rulesGenerator is an instance of RulesGenerator
	*/
	public function testRulesGeneratorInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\RulesGenerator',
			$this->configurator->rulesGenerator
		);
	}

	/**
	* @testdox $configurator->tags is an instance of TagCollection
	*/
	public function testTagsInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\Collections\\TagCollection',
			$this->configurator->tags
		);
	}

	/**
	* @testdox $configurator->templateChecker is an instance of TemplateChecker
	*/
	public function testTemplateCheckerInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\TemplateChecker',
			$this->configurator->templateChecker
		);
	}

	/**
	* @testdox $configurator->templateNormalizer is an instance of TemplateNormalizer
	*/
	public function testTemplateNormalizerInstance()
	{
		$this->assertInstanceOf(
			'akmaljp\\DriveMaru\\Configurator\\TemplateNormalizer',
			$this->configurator->templateNormalizer
		);
	}

	/**
	* @testdox asConfig() does not call finalize() before retrieving the plugins' config
	*/
	public function testAsConfigNoFinalize()
	{
		$plugin = new DummyPluginConfigurator($this->configurator);
		$this->configurator->plugins->add('Dummy', $plugin);

		$config = $this->configurator->asConfig();
		$this->assertArrayMatches(
			['plugins' => ['Dummy' => ['finalized' => 0]]],
			$config
		);
	}

	/**
	* @testdox asConfig() returns an array with a rootContext element
	*/
	public function testAsConfigRootContext()
	{
		$config = $this->configurator->asConfig();
		$this->assertInternalType('array', $config);
		$this->assertArrayHasKey('rootContext', $config);
	}

	/**
	* @testdox asConfig() returns an array with a registeredVars element that contains urlConfig
	*/
	public function testAsConfigRegisteredVars()
	{
		$config = $this->configurator->asConfig();
		$this->assertInternalType('array', $config);
		$this->assertArrayHasKey('registeredVars', $config);
		$this->assertArrayHasKey('urlConfig', $config['registeredVars']);
	}

	/**
	* @testdox asConfig() returns all registeredVars including empty arrays
	*/
	public function testAsConfigRegisteredVarsEmpty()
	{
		$this->configurator->registeredVars['foo'] = [];
		$config = $this->configurator->asConfig();
		$this->assertArrayHasKey('foo', $config['registeredVars']);
		$this->assertSame([], $config['registeredVars']['foo']);
	}

	/**
	* @testdox asConfig() adds regexpLimit to the plugin's configuration if it's not specified and the plugin has a regexp
	*/
	public function testAsConfigAddRegexpLimit()
	{
		$plugin = new DummyPluginConfigurator($this->configurator);
		$plugin->setConfig(['regexp' => '//']);

		$this->configurator->plugins->add('Dummy', $plugin);
		$config = $this->configurator->asConfig();

		$this->assertArrayMatches(
			[
				'plugins' => [
					'Dummy' => [
						'regexpLimit' => 50000
					]
				]
			],
			$config
		);
	}

	/**
	* @testdox asConfig() removes regexpLimit from the plugin's configuration if it does not have a regexp
	*/
	public function testAsConfigRemoveRegexpLimit()
	{
		$plugin = new DummyPluginConfigurator($this->configurator);
		$plugin->setConfig(['regexpLimit' => 1000]);

		$this->configurator->plugins->add('Dummy', $plugin);
		$config = $this->configurator->asConfig();

		$this->assertArrayMatches(
			[
				'plugins' => [
					'Dummy' => [
						'regexpLimit' => null
					]
				]
			],
			$config
		);
	}

	/**
	* @testdox asConfig() adds quickMatch to the plugin's configuration if available
	*/
	public function testAsConfigAddQuickMatch()
	{
		$this->configurator->plugins->add(
			'Dummy',
			new DummyPluginConfigurator($this->configurator)
		)->setQuickMatch('foo');
		$config = $this->configurator->asConfig();

		$this->assertArrayMatches(
			[
				'plugins' => [
					'Dummy' => [
						'quickMatch' => 'foo'
					]
				]
			],
			$config
		);
	}

	/**
	* @testdox asConfig() omits a plugin's quickMatch if it's false
	*/
	public function testAsConfigOmitsQuickMatch()
	{
		$this->configurator->plugins->add(
			'Dummy',
			new DummyPluginConfigurator($this->configurator)
		);
		$config = $this->configurator->asConfig();

		$this->assertArrayMatches(
			[
				'plugins' => [
					'Dummy' => [
						'quickMatch' => null
					]
				]
			],
			$config
		);
	}

	/**
	* @testdox asConfig() adds allowedChildren and allowedDescendants bitfields to each tag
	*/
	public function testAsConfigTagBitfields()
	{
		$this->configurator->tags->add('A')->rules->allowChild('A');
		$this->configurator->rootRules->allowChild('A');
		$config = $this->configurator->asConfig();

		$this->assertArrayMatches(
			[
				'tags' => [
					'A' => ['allowed' => [1]]
				]
			],
			$config
		);
	}

	/**
	* @testdox Removes JavaScript-specific data from tag filters
	*/
	public function testAsConfigRemovesJavaScriptTagFilters()
	{
		$pc = new TagFilter('is_object');
		$pc->setJS('function(tag){return false;}');

		$this->configurator->tags->add('A')->filterChain->append($pc);

		$parser = $this->getParser();
		$tagsConfig = $this->readAttribute($parser, 'tagsConfig');

		$this->assertArrayNotHasKey(
			'js',
			$tagsConfig['A']['filterChain'][0]
		);
	}

	/**
	* @testdox Removes JavaScript-specific data from attribute filters
	*/
	public function testAsConfigRemovesJavaScriptAttributeFilters()
	{
		$filter = new AttributeFilter('is_object');
		$filter->setJS('function(v){return false;}');

		$this->configurator->tags->add('A')->attributes->add('a')->filterChain->append($filter);

		$parser = $this->getParser();
		$tagsConfig = $this->readAttribute($parser, 'tagsConfig');

		$this->assertArrayNotHasKey(
			'js',
			$tagsConfig['A']['attributes']['a']['filterChain'][0]
		);
	}

	/**
	* @testdox $configurator->BBCodes returns an instance of the BBCodes plugin's configurator, and loads it if applicable
	*/
	public function testMagicGetPlugin()
	{
		$plugin = $this->configurator->BBCodes;

		$this->assertInstanceOf('akmaljp\\DriveMaru\\Plugins\\BBCodes\\Configurator', $plugin);
		$this->assertSame($plugin, $this->configurator->BBCodes);
	}

	/**
	* @testdox isset($configurator->BBCodes) returns whether the BBCodes plugin is loaded
	*/
	public function testMagicIssetPlugin()
	{
		$this->assertFalse(isset($this->configurator->BBCodes));
		$this->configurator->BBCodes;
		$this->assertTrue(isset($this->configurator->BBCodes));
	}

	/**
	* @testdox unset($configurator->BBCodes) unloads the BBCodes plugin
	*/
	public function testMagicUnsetPlugin()
	{
		$this->configurator->BBCodes;
		$this->assertTrue(isset($this->configurator->BBCodes));
		unset($this->configurator->BBCodes);
		$this->assertFalse(isset($this->configurator->BBCodes));
	}

	/**
	* @testdox Setting $configurator->Foo adds Foo to the plugins collection
	*/
	public function testMagicSetPlugin()
	{
		$plugin = new \akmaljp\DriveMaru\Plugins\Keywords\Configurator($this->configurator);
		$this->configurator->Foo = $plugin;
		$this->assertSame($plugin, $this->configurator->plugins['Foo']);
	}

	/**
	* @testdox isset($configurator->foo) returns false if the var "foo" is not registered
	*/
	public function testMagicIssetVarFalse()
	{
		$this->assertFalse(isset($this->configurator->foo));
	}

	/**
	* @testdox isset($configurator->foo) returns true if $configurator->registeredVars['foo'] exists
	*/
	public function testMagicIssetVarTrue()
	{
		$this->configurator->registeredVars['foo'] = 1;
		$this->assertTrue(isset($this->configurator->foo));
	}

	/**
	* @testdox $configurator->foo returns $configurator->registeredVars['foo'] if it exists
	*/
	public function testMagicGetVar()
	{
		$this->configurator->registeredVars['foo'] = 42;
		$this->assertSame(42, $this->configurator->foo);
	}

	/**
	* @testdox $configurator->foo throws an exception if $configurator->registeredVars['foo'] does not exist
	* @expectedException RuntimeException
	* @expectedExceptionMessage Undefined property 'akmaljp\DriveMaru\Configurator::$foo'
	*/
	public function testMagicGetInexistentVar()
	{
		$this->configurator->foo;
	}

	/**
	* @testdox unset($configurator->foo) unsets $configurator->registeredVars['foo']
	*/
	public function testMagicUnsetVar()
	{
		$this->configurator->registeredVars['foo'] = 1;
		$this->assertTrue(isset($this->configurator->foo));
		unset($this->configurator->foo);
		$this->assertFalse(isset($this->configurator->foo));
	}

	/**
	* @testdox Setting $configurator->foo sets $this->configurator->registeredVars['foo']
	*/
	public function testMagicSetVar()
	{
		$this->configurator->foo = 42;
		$this->assertSame(42, $this->configurator->registeredVars['foo']);
	}

	/**
	* @testdox finalize() adds root rules
	*/
	public function testAddHTML5RulesRoot()
	{
		$this->configurator->tags->add('UL')->template
			= '<ul><xsl:apply-templates/></ul>';

		$this->configurator->tags->add('LI')->template
			= '<li><xsl:apply-templates/></li>';

		$this->configurator->finalize();

		$this->assertArrayHasKey('allowChild', $this->configurator->rootRules);
		$this->assertSame(['UL'], $this->configurator->rootRules['allowChild']);
	}

	/**
	* @testdox finalize() adds tag rules
	*/
	public function testAddHTML5RulesTags()
	{
		$ul = $this->configurator->tags->add('UL');
		$ul->template = '<ul><xsl:apply-templates/></ul>';

		$li = $this->configurator->tags->add('LI');
		$li->template = '<li><xsl:apply-templates/></li>';

		$this->configurator->finalize();

		$this->assertArrayHasKey('allowChild', $ul->rules);
		$this->assertSame(['LI'], $ul->rules['allowChild']);
		$this->assertArrayHasKey('allowChild', $li->rules);
		$this->assertSame(['UL'], $li->rules['allowChild']);
	}

	/**
	* @testdox finalize() does not overwrite boolean tag rules
	*/
	public function testAddHTML5RulesTagsNoOverwrite()
	{
		$ul = $this->configurator->tags->add('ul');
		$ul->template = '<ul><xsl:apply-templates/></ul>';
		$ul->rules->preventLineBreaks(false);

		$this->configurator->finalize();

		$this->assertFalse($ul->rules['preventLineBreaks']);
	}

	/**
	* @testdox loadBundle('../Invalid') throws an exception
	* @expectedException InvalidArgumentException
	* @expectedExceptionMessage Invalid bundle name
	*/
	public function testLoadBundleInvalid()
	{
		$this->configurator->loadBundle('../Invalid');
	}

	/**
	* @testdox loadBundle('Forum') adds the Forum bundle's configuration
	*/
	public function testLoadBundle()
	{
		$this->configurator->loadBundle('Forum');
		$this->assertTrue($this->configurator->BBCodes->exists('B'));
	}

	/**
	* @testdox saveBundle('Foo', '/tmp/foo') saves a bundle Foo to /tmp/foo
	*/
	public function testSaveBundle()
	{
		$filepath = $this->tempnam();
		$this->configurator->saveBundle('Foo', $filepath);

		$this->assertFileExists($filepath);

		$file = file_get_contents($filepath);
		$this->assertStringStartsWith('<?php', $file);
		$this->assertContains('class Foo', $file);
	}

	/**
	* @testdox saveBundle() returns true on success
	*/
	public function testSaveBundleReturnTrue()
	{
		$filepath = $this->tempnam();
		$return   = $this->configurator->saveBundle('Foo', $filepath);

		$this->assertTrue($return);
	}

	/**
	* @testdox saveBundle() returns false on failure
	*/
	public function testSaveBundleReturnFalse()
	{
		$filepath = '/does/not/exist/' . uniqid();
		$return   = @$this->configurator->saveBundle('Foo', $filepath);

		$this->assertFalse($return);
	}

	/**
	* @testdox finalize() returns a parser and a renderer
	*/
	public function testFinalizeDefault()
	{
		$return = $this->configurator->finalize();

		$this->assertArrayHasKey('parser', $return);
		$this->assertInstanceOf('akmaljp\\DriveMaru\\Parser', $return['parser']);

		$this->assertArrayHasKey('renderer', $return);
		$this->assertInstanceOf('akmaljp\\DriveMaru\\Renderer', $return['renderer']);
	}

	/**
	* @testdox finalize() does not return a JS parser by default
	*/
	public function testFinalizeDefaultNoJS()
	{
		$return = $this->configurator->finalize();

		$this->assertArrayNotHasKey('js', $return);
	}

	/**
	* @testdox finalize() returns a JS parser if JavaScript was enabled
	*/
	public function testFinalizeJSEnabled()
	{
		$this->configurator->enableJavaScript();
		$return = $this->configurator->finalize();

		$this->assertArrayHasKey('js', $return);
	}

	/**
	* @testdox finalize() calls each plugin's finalize()
	*/
	public function testFinalizePluginFinalize()
	{
		$plugin = new DummyPluginConfigurator($this->configurator);
		$this->configurator->plugins->add('Dummy', $plugin);
		$this->configurator->finalize();

		$this->assertArrayMatches(['finalized' => 1], $plugin->asConfig());
	}

	/**
	* @testdox finalize() calls each plugin's finalize() once, even if JavaScript is enabled
	*/
	public function testFinalizePluginFinalizeOnce()
	{
		$plugin = new DummyPluginConfigurator($this->configurator);
		$this->configurator->enableJavaScript();
		$this->configurator->plugins->add('Dummy', $plugin);
		$this->configurator->finalize();

		$this->assertArrayMatches(['finalized' => 1], $plugin->asConfig());
	}
}

class DummyPluginConfigurator extends ConfiguratorBase
{
	protected $config = ['finalized' => 0, 'foo' => 1];

	public function asConfig()
	{
		return $this->config;
	}

	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	public function finalize()
	{
		++$this->config['finalized'];
	}
}