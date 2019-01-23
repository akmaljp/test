<h2>Fatdown, a Markdown bundle that doesn't suck too bad</h2>

**Fatdown** is a bundle based on the [Litedown](/Plugins/Litedown/Synopsis.md) plugin which supports most of Markdown's features, plus the MediaEmbed and FancyPants plugins for media embedding and enhanced typography.

### Demo

You can try the [real-time JavaScript demo](https://akmaljp.github.io/DriveMaru/fatdown.html), or you can compare Fatdown to various Markdown implementations via [the wonderful Babelmark 2](http://johnmacfarlane.net/babelmark2/).

### Examples

```php
use akmaljp\DriveMaru\Bundles\Fatdown as DriveMaru;

$text = '**Fatdown** implements a Markdown-like syntax plus extra Stuff(tm).';
$xml  = DriveMaru::parse($text);
$html = DriveMaru::render($xml);

echo $html;
```
```html
<p><strong>Fatdown</strong> implements a Markdown-like syntax plus extra Stuff™.</p>
```

#### Why Fatdown doesn't suck

Unlike the original Markdown, Fatdown's HTML support **does not leave you wide open to [XSS](https://en.wikipedia.org/wiki/Cross-site_scripting)**. Markdown is designed for publishers, not user input.

```php
use akmaljp\DriveMaru\Bundles\Fatdown as DriveMaru;

$text = '<img src="http://127.0.0.1/fake.png" onerror="alert(1)"/>';
$xml  = DriveMaru::parse($text);
$html = DriveMaru::render($xml);

echo $html;
```
```html
<p><img src="http://127.0.0.1/fake.png"></p>
```

### Plugins

 * Autoemail
 * Autolink
 * Escaper
 * FancyPants
 * HTMLComments
 * HTMLElements
 * HTMLEntities
 * Litedown
 * MediaEmbed
 * PipeTables

### HTMLElements

 * `a` with a mandatory `href` attribute and an optional `title` attributes
 * `abbr` with an optional `title` attribute
 * `b`, `em`, `i`, `s`, `strong`, `u`
 * `br`
 * `code`
 * `dl`, `dt` and `dd`
 * `del` and `ins`
 * `div` with an optional `class` attribute
 * `hr`
 * `img` with a mandatory `src` attribute and optional `alt` and `title` attributes
 * `rb`, `rp`, `rt` and `rtc` for all your `ruby` needs
 * `span` with an optional `class` attribute
 * `sub` and `sup`
 * `table`, `tbody`, `tfoot`, `thead`
 * `td` with optional `colspan` and `rowspan` attributes
 * `th` with optional `colspan`, `rowspan` and `scope` attributes

### MediaEmbed

URLs from the following sites are automatically embedded: Bandcamp, Dailymotion, Facebook, Liveleak, Soundcloud, Spotify, Twitch, Vimeo, Vine and YouTube.
