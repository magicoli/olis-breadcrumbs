# Breadcrumbs Shortcode

![Stable 0.1.3](https://badgen.net/badge/Stable/0.1.3/00aa00)
![WordPress 4.5 - 6.2.2](https://badgen.net/badge/WordPress/4.5%20-%206.2.2/3858e9)
![Requires PHP 5.7](https://badgen.net/badge/PHP/5.7/7884bf)
![License AGPLv3 or later](https://badgen.net/badge/License/AGPLv3%20or%20later/552b55)

Register [breadcrumbs] shortcode for inclusion in posts or templates.

## Description

Several ways to add breadcrumbs to your pages, if your theme does not support them.
If you theme does support breadcrumbs, you probably wouldn't want to use this plugin, as it is likely to have far less options.

You can add breadcrumbs with any of these methods:

- `[breadcrumbs]` shortcode
- Breadcrumbs widget
- Breadcrumbs Divi Module (for Divi Themes)

Here are the options for the shordcode.

- `[breadcrumbs exclude-home="true"]` do not start the breadcrumbs with home page, default false
- `[breadcrumbs exclude-archives="true"]` do not include main articles archive link, default false
- `[breadcrumbs exclude-title="true"]` do not end the breadcrumbs with the post title, default false
- `[breadcrumbs separator="×"]` separator, default "/"

Equivalent options are available in the widget and the Divi Module.

## Frequently Asked Questions

### How can I customize the breadcrumbs' separator?

You can customize the separator by adding the `separator` attribute to the shortcode like so: `[breadcrumbs separator="×"]`. The default separator is "/" (slash).

### I've activated the plugin, but I don't see the breadcrumbs. Why?

First, make sure you've added the `[breadcrumbs]` shortcode to your templates or posts. If you still can't see them, it could be due to your theme's structure. Some themes may not support this plugin out of the box.

### How can I use this plugin with Divi Builder?

If you're using Divi Builder, you can use the Breadcrumbs Divi Module that comes with this plugin. The module has the same options as the shortcode.

### Any other question

The answer is 42.

