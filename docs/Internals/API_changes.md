See also [general changes](Changes.md).


## 2.0.0

Elements that were deprecated in 1.x will be removed.


## 1.3.0

`akmaljp\DriveMaru\Configurator\JavaScript::$exportMethods` has been renamed to `$exports`. The `$exportMethods` property is silently deprecated but remains as an alias.

`akmaljp\DriveMaru\Plugins\Emoji\Configurator::$attrName` is deprecated but remains functional. The names of the attributes used by this plugin will be hardcoded in a future version.

`akmaljp\DriveMaru\Plugins\Emoji\Configurator::$aliases` has been made accessible (see [API](http://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Plugins/Emoji/Configurator.html#property_aliases) and [docs](../Plugins/Emoji/Configuration.md#manage-aliases) for usage) and the following methods are now deprecated:

 - addAlias
 - getAliases
 - removeAlias

The following properties are now deprecated in `akmaljp\DriveMaru\Configurator\JavaScript\Minifiers\ClosureCompilerApplication`. Check out [the documentation](https://akmaljpDriveMaru.readthedocs.io/JavaScript/Minifiers/#google-closure-compiler-application) for the recommended usage.

 - closureCompilerBin
 - javaBin


## 1.2.0

The `akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper` class have been split into subcomponents. The current API is deprecated but remains fully functional. The new API is as follows:

* **akmaljp\DriveMaru\Configurator\Helpers\NodeLocator**

    - getAttributesByRegexp
    - getCSSNodes
    - getElementsByRegexp
    - getJSNodes
    - getObjectParamsByRegexp
    - getURLNodes<br><br>

* **akmaljp\DriveMaru\Configurator\Helpers\TemplateLoader**

    - load *<small>(previously: loadTemplate)</small>*
    - save *<small>(previously: saveTemplate)</small>*<br><br>

* **akmaljp\DriveMaru\Configurator\Helpers\TemplateModifier**

    - replaceTokens<br><br>

* **akmaljp\DriveMaru\Configurator\Helpers\XPathHelper**

    - parseEqualityExpr


## 1.0.0

The following method and properties have been removed from `akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator`:

 - `appendTemplate()` — The [same functionality](../Plugins/MediaEmbed/Append_template.md) can be implemented as a template normalizer.
 - `$captureURLs` — Disabling the plugin at runtime produces the same effect.
 - `$createIndividualBBCodes` — Individual BBCodes can be [created manually](../Plugins/MediaEmbed/Synopsis.md#example).

In addition, support for custom schemes has been removed from the MediaEmbed plugin. The [same functionality](../Plugins/Preg/Practical_examples.md#capture-spotify-uris) can be produced using the Preg plugin.

The `predefinedAttributes` property of `akmaljp\DriveMaru\Plugins\BBCodes\Configurator\BBCode` has been removed, as well as the `akmaljp\DriveMaru\Plugins\BBCodes\Configurator\AttributeValueCollection` class.

The return value of tag filters is not used to invalidate tags anymore. Tags must be explicitly invalidated in tag filters.

Support for attribute generators and the `{RANDOM}` token in BBCode definitions has been removed. The same behaviour can be defined in PHP by prepending a custom tag filter to a tag's `filterChain`.

The `akmaljp\DriveMaru\Configurator\Exceptions\InvalidTemplateException` and `akmaljp\DriveMaru\Configurator\Exceptions\InvalidXslException` classes have been removed.


## 0.13.0

`akmaljp\DriveMaru\Parser\BuiltInFilters` has been removed and split into multiple classes.

`akmaljp\DriveMaru\Parser\Logger::get()` has been renamed `akmaljp\DriveMaru\Parser\Logger::getLogs()`.


## 0.12.0

Support for PHP 5.3 has been abandoned. Releases are now based on the `release/php5.4` branch, which requires PHP 5.4.7 or greater. The `release/php5.3` branch will remain active for some time but is unsupported.

The PHP renderer's source has been removed from the renderer instance.

The `HostedMinifier` and `RemoteCache` minifiers have been removed.

`akmaljp\DriveMaru\Configurator\Helpers\TemplateHelper::getMetaElementsRegexp()` has been removed.

`akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector::getDOM()` has been removed.

The `metaElementsRegexp` property of `akmaljp\DriveMaru\Renderer` has been removed. Meta elements `e`, `i` and `s` are now always removed from the source XML before rendering.

The `quickRenderingTest` property of the PHP renderer is now protected.

`akmaljp\DriveMaru\Configurator\Helpers\XPathHelper::export()` has been moved to `akmaljp\DriveMaru\Utils\XPath::export()`.

`akmaljp\DriveMaru\Configurator\TemplateNormalization` has been replaced by `akmaljp\DriveMaru\Configurator\TemplateNormalizations\AbstractNormalization`.

The `branchTableThreshold` property of `akmaljp\DriveMaru\Configurator\RendererGenerators\PHP\Serializer` has been removed.

The `generateConditionals()` and `generateBranchTable()` methods of `akmaljp\DriveMaru\Configurator\RendererGenerators\PHP\Quick` have been removed.

The template used by the Emoji plugin is now hardcoded and defaults to using EmojiOne 3.1's PNG assets. The following methods have been removed from the Emoji configurator:

 * `forceImageSize()`
 * `omitImageSize()`
 * `setImageSize()`
 * `useEmojiOne()`
 * `usePNG()`
 * `useSVG()`
 * `useTwemoji()`


## 0.11.0

The optional argument of `akmaljp\DriveMaru\Configurator\RulesGenerator::getRules()` has been removed.

The optional argument of `akmaljp\DriveMaru\Configurator::finalize()` has been removed.

The following methods have been removed:

 * `akmaljp\DriveMaru\Configurator::addHTML5Rules()`  
   Tag rules are systematically added during `finalize()`. See [Automatic rules generation](../Rules/Automatic_rules_generation.md).

 * `akmaljp\DriveMaru\Configurator\Collections\Ruleset::defaultChildRule()`  
   The default is now `deny`.

 * `akmaljp\DriveMaru\Configurator\Collections\Ruleset::defaultDescendantRule()`  
   The default is now `deny`.

 * `akmaljp\DriveMaru\Configurator\Helpers\TemplateInspector::isIframe()`

In addition, the meaning of the `allowDescendant` and `denyDescendant` rules have been changed to exclude the tag's child. See [Tag rules](../Rules/Tag_rules.md).


## 0.10.0

`akmaljp\DriveMaru\Plugins\Censor\Helper::reparse()` has been removed.

`akmaljp\DriveMaru\Parser\Tag::setSortPriority()` has been removed. See the [0.7.0 notes](#070) for more info.


## 0.9.0

`akmaljp\DriveMaru\Configurator\TemplateForensics` has been renamed to `akmaljp\DriveMaru\Configurator\TemplateInspector`.

`akmaljp\DriveMaru\Configurator\Items\Template::getForensics()` has been renamed to `akmaljp\DriveMaru\Configurator\Items\Template::getInspector()`.


## 0.8.0

The `akmaljp\DriveMaru\Plugins\MediaEmbed\Configurator\SiteDefinitionProvider` interface has been removed.

`$configurator->MediaEmbed->defaultSites` is now an iterable collection that implements the `ArrayAccess` interface. See [its API](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Plugins/MediaEmbed/Configurator/Collections/SiteDefinitionCollection.html).


## 0.7.0

`akmaljp\DriveMaru\Parser\Tag::setSortPriority()` has been deprecated. It will emit a warning upon use and will be removed in a future version.

The following methods now accept an additional argument to set a tag's priority at the time of its creation:

 * [addBrTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addBrTag)
 * [addCopyTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addCopyTag)
 * [addEndTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addEndTag)
 * [addIgnoreTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addIgnoreTag)
 * [addParagraphBreak](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addParagraphBreak)
 * [addSelfClosingTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addSelfClosingTag)
 * [addStartTag](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addStartTag)
 * [addTagPair](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addTagPair)
 * [addVerbatim](https://akmaljp.github.io/DriveMaru/api/akmaljp/DriveMaru/Parser.html#method_addVerbatim)