<h2>MediaPack, embed third-party media from a hundred different sites</h2>

### Example

```php
use akmaljp\DriveMaru\Bundles\MediaPack as DriveMaru;

$text = 'https://www.youtube.com/watch?v=QH2-TGUlwu4';
$xml  = DriveMaru::parse($text);
$html = DriveMaru::render($xml);

echo $html;
```
```html
<span data-akmaljp-mediaembed="youtube" style="display:inline-block;width:100%;max-width:640px"><span style="display:block;overflow:hidden;position:relative;padding-bottom:56.25%"><iframe allowfullscreen="" scrolling="no" style="background:url(https://i.ytimg.com/vi/QH2-TGUlwu4/hqdefault.jpg) 50% 50% / cover;border:0;height:100%;left:0;position:absolute;width:100%" src="https://www.youtube.com/embed/QH2-TGUlwu4"></iframe></span></span>
```
