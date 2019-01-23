## Add a site manually

To add a site, you'll need to pass as a second argument to `add()` an array that contains at least 3 elements:

* `host` is the domain name of the URLs you want to match, e.g. `example.com` (including subdomains such as `www.example.com`)
* At least one of the following:
    - `extract` is a regexp used to extract values from the URL.
    - `scrape` is an array that must contain at least one `extract` and zero or more `match` where:
        * `match` is a regexp used to determine whether to scrape the content of the URL. If it's not specified, every URL is scraped.
        * `extract` is a regexp used to extract values from the scraped page.
* Exactly one of the following:
    - A `choose` array that contains a `when` array and an `otherwise` array.
        * `when` must contain the following two elements:
            - A `test` string that contains an XPath condition.
            - An `iframe` or `flash` element as specified below.
        * `otherwise` must contain one `iframe` or `flash` element as specified below.
    - An `iframe` or `flash` element that contains an array of attributes:
        * `src` contains the URL of the iframe or Flash object.
        * `width` and `height` are optional and default to 640 × 360.
        * Other attributes such as `allowfullscreen` or `scrolling` are automatically added where necessary.

You can specify multiple `host`, `scheme`, `scrape`, `extract`, `match` or `when` values using arrays.

### How to configure multiple `host` and `extract` values

```php
$configurator = new akmaljp\DriveMaru\Configurator;

$configurator->MediaEmbed->add(
	'youtube',
	[
		'host'    => ['youtube.com', 'youtu.be'],
		'extract' => [
			"!youtube\\.com/watch\\?v=(?'id'[-0-9A-Z_a-z]+)!",
			"!youtu\\.be/(?'id'[-0-9A-Z_a-z]+)!"
		],
		'iframe'  => [
			'width'  => 560,
			'height' => 315,
			'src'    => 'http://www.youtube.com/embed/{@id}'
		]
	]
);

// Get an instance of the parser and the renderer
extract($configurator->finalize());

$text = 'http://www.youtube.com/watch?v=-cEzsCAzTak';
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="youtube" style="display:inline-block;width:100%;max-width:560px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="http://www.youtube.com/embed/-cEzsCAzTak" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>
```

### How to configure the `iframe` renderer

```php
$configurator = new akmaljp\DriveMaru\Configurator;

$configurator->MediaEmbed->add(
	'youtube',
	[
		'host'    => 'youtube.com',
		'extract' => "!youtube\\.com/watch\\?v=(?'id'[-0-9A-Z_a-z]+)!",
		'iframe'  => [
			'width'  => 560,
			'height' => 315,
			'src'    => 'http://www.youtube.com/embed/{@id}'
		]
	]
);

// Get an instance of the parser and the renderer
extract($configurator->finalize());

$text = '[media]http://www.youtube.com/watch?v=-cEzsCAzTak[/media]';
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="youtube" style="display:inline-block;width:100%;max-width:560px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" src="http://www.youtube.com/embed/-cEzsCAzTak" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>
```

### How to configure the `flash` renderer

```php
$configurator = new akmaljp\DriveMaru\Configurator;

$configurator->MediaEmbed->add(
	'dailymotion',
	[
		'host'    => 'dailymotion.com',
		'extract' => "!dailymotion\.com/(?:video/|user/[^#]+#video=)(?'id'[A-Za-z0-9]+)!",
		'flash'   => [
			'width'  => 560,
			'height' => 315,
			'src'    => 'http://www.dailymotion.com/swf/{@id}'
		]
	]
);

// Get an instance of the parser and the renderer
extract($configurator->finalize());

$text = '[media]http://www.dailymotion.com/video/x222z1[/media]';
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="dailymotion" style="display:inline-block;width:100%;max-width:560px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><object data="http://www.dailymotion.com/swf/x222z1" style="height:100%;left:0;position:absolute;width:100%" type="application/x-shockwave-flash" typemustmatch=""><param name="allowfullscreen" value="true"></object></span></span>
```

### How to scrape content

Some media sites don't put all of the necessary data (e.g. the ID of a video) in the URL. In that case, you may have to retrieve it from the page itself.

Note that scraping content is a pretty expensive operation that can take several seconds to complete, in part due to network latency and the responsiveness of the target site.

```php
$configurator = new akmaljp\DriveMaru\Configurator;

$configurator->MediaEmbed->add(
	'slideshare',
	[
		'host'   => 'slideshare.net',
		'scrape' => [
			// Here we ensure that we don't scrape just every link to http://slideshare.net
			'match'   => '!slideshare\\.net/[^/]+/\\w!',
			// Retrieve the presentationId from the embedded JSON
			'extract' => '!"presentationId":(?<id>[0-9]+)!'
		],
		'iframe' => [
			'width'  => 427,
			'height' => 356,
			'src'    => 'http://www.slideshare.net/slideshow/embed_code/{@id}'
		]
	]
);

// Get an instance of the parser and the renderer
extract($configurator->finalize());

$text = 'http://www.slideshare.net/Slideshare/10-million-uploads-our-favorites';
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="slideshare" style="display:inline-block;width:100%;max-width:427px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:83.372365%"><iframe allowfullscreen="" scrolling="no" src="http://www.slideshare.net/slideshow/embed_code/21112125" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>
```

### Specify a different URL for scraping

If the URL used for scraping is different from the media's URL, you can specify it in the `url` element of the `scrape` array. You can also use variables in the URL using the familiar syntax `{@id}`. Values for those variables come from named captures in previous `extract` regexp and from the tag's attributes if applicable.

For example: the dimensions of a Gfycat video are mentionned in the metadata of their page. However, if someone posted a direct link to a Gfycat .gif image such as `http://giant.gfycat.com/SereneIllfatedCapybara.gif`, the dimensions would not be available. In the following example, we configure `scrape` with a custom URL that is known to include the original image's dimensions.

In addition, we specify that both the `width` and `height` attributes should be filtered as unsigned integer.

```php
$configurator = new akmaljp\DriveMaru\Configurator;

$configurator->MediaEmbed->add(
	'gfycat',
	[
		'host'       => 'gfycat.com',
		'attributes' => [
			'height' => ['filterChain' => '#uint'],
			'width'  => ['filterChain' => '#uint']
		],
		'extract'    => "!gfycat\\.com/(?'id'\\w+)!",
		'scrape'     => [
			'url'     => 'http://gfycat.com/{@id}',
			'extract' => [
				'!property="og:image:height"\s*content="(?<height>\d+)!',
				'!property="og:image:width"\s*content="(?<width>\d+)!'
			]
		],
		'iframe'     => [
			'width'     => '{@width}',
			'height'    => '{@height}',
			'src'       => '//gfycat.com/iframe/{@id}'
		]
	]
);

// Get an instance of the parser and the renderer
extract($configurator->finalize());

$text = 'http://giant.gfycat.com/SereneIllfatedCapybara.gif';
$xml  = $parser->parse($text);
$html = $renderer->render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="gfycat" style="display:inline-block;width:100%;max-width:600px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.3333333333333%"><iframe allowfullscreen="" scrolling="no" src="//gfycat.com/iframe/SereneIllfatedCapybara" style="border:0;height:100%;left:0;position:absolute;width:100%"></iframe></span></span>
```

### Add custom HTTP headers when scraping

Custom HTTP headers can be specified in the `scrape` configuration.

```php
$configurator->MediaEmbed->add(
	'sitename',
	[
		'host'   => 'example.org',
		'scrape' => [
			'extract' => '#example\\.org/video/(?<id>\\d+)#',
			'header'  => [
				'Cookie: mycookie=1',
				'User-agent: foo-agent'
			]
		],
		'iframe' => ['src' => '//example.org/embed/{@id}']
	]
);
```
