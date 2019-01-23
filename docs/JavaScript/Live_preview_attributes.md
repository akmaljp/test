### data-akmaljp-livepreview-postprocess

The content of a `data-akmaljp-livepreview-postprocess` attribute is executed after the new DOM has been generated and before it's inserted into the target element. In this context, `this` will refer to the attribute's element.

```html
<span data-akmaljp-livepreview-postprocess="this.style.color='red'">This will be red.</span>
```

### data-akmaljp-livepreview-ignore-attrs

Contains a space-separated list of attributes whose content should not be replaced or removed in the live preview. Used in some MediaEmbed sites whose height is set dynamically.

```html
<span style="color:{@color}" data-akmaljp-livepreview-ignore-attrs="style">This color will not change.</span>
```