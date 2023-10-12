> A simple, lightweight jQuery loading overlay plugin.

## Features
- Apply loading overlay to dom element.
- Lightweight plugin and very easy to use.

## Setup
Include plugin stylesheet.
```html
<link rel="stylesheet" href="css/loading-overlay.jquery.css">
```

Include plugin and jQuery (if not yet installed) as dependency.
```html
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script src="js/loading-overlay.jquery.js"></script>
```
Init plugin with choosen options.
```html
<script>
$('your-selector').loadingOverlay(true|false, {
    ...settings
});
</script>
```

## Configuration

|Setting|Default Value|Description|
|---|---|---|
|icon|`null`|Overlay icon url.|
|backgroundColor|`rgba(255,255,255,0.85)`|Overlay background color.|
