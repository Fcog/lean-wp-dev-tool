# Assets

# Usage

```php
$assets = new \Lean\Assets( $args );
$assets->load();
```

Where `$args` is an array with a group of options you can use to customize your asset loading the
options available are:


- `css_uri` Path to the CSS being loaded.
- `css_version` - Default `false`, version to specify at the end of the css loaded, useful to 
prevent the cache of the browser on the styles.
- `js_version` - Default `false`, version to specify at the end of the JS loaded, useful to prevent
- `js_uri` - Deafault `''` empty string, path where the JS is located.
- `js_version` - Default `false`, version to specify at the end of the JS loaded, useful to prevent
  cache of script by the browser.
- `jquery_uri` - Default `''` empty string, useful to change the default path to jQuery by a Google
  CDN URL instead.
- `jquery_version` - Default `false` if you specify a version number is used to specify the number
  of jQuery to load.
- `automatic_suffix` - Default `false` This flags allows you to disable the option to add
  automatically the `.min` suffix to each asset loaded when the `production` mode is enabled.
