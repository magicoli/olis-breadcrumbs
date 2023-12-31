=== Oli's Breadcrumbs ===
Contributors: magicoli
Donate link: https://magiiic.com/
Tags: comments, spam
Requires at least: 4.5
Tested up to: 6.2.2
Requires PHP: 5.7
Stable tag: 1.0
License: AGPLv3 or later
License URI: https://www.gnu.org/licenses/agpl-3.0.html

Add configurable breadcrumbs via shortcode, widget, Divi module or WPBakery element.

== Description ==

Several ways to add breadcrumbs to your pages, if your theme does not support them.
If you theme already supports breadcrumbs, you probably don't need this plugin, as it is likely to have less options.

You can add breadcrumbs with any of these methods:

* `[breadcrumbs]` shortcode
* Breadcrumbs widget
* Breadcrumbs Divi Module (for Divi Themes or with Divi plugin)
* Breadcrumbs Element WPBakery Page Builder (aka js_composer aka Visual Composer)

Here are the options for the shordcode.

* `[breadcrumbs exclude-home="true"]` do not start the breadcrumbs with home page, default false
* `[breadcrumbs exclude-archives="true"]` do not include main articles archive link, default false
* `[breadcrumbs exclude-title="true"]` do not end the breadcrumbs with the post title, default false
* `[breadcrumbs separator="×"]` separator, default "/"

Equivalent options are available in the widget and the Divi Module.

== Installation ==

1. Upload `breadcrumbs-shortcode` folder in the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add `[breadcrumbs]` in your templates or posts

== Frequently Asked Questions ==

= How can I customize the breadcrumbs' separator? =

You can customize the separator by adding the `separator` attribute to the shortcode like so: `[breadcrumbs separator="×"]`. The default separator is "/" (slash).

= I've activated the plugin, but I don't see the breadcrumbs. Why? =

First, make sure you've added the `[breadcrumbs]` shortcode to your templates or posts. If you still can't see them, it could be due to your theme's structure. Some themes may not support this plugin out of the box.

= How can I use this plugin with Divi Builder? =

If you're using Divi Builder, you can use the Breadcrumbs Divi Module that comes with this plugin. The module has the same options as the shortcode.

= Any other question =

The answer is 42.

== Changelog ==

= 1.0 =
* new plugin final slug is olis-breadcrumbs
* updated short description and readme

= 0.1.5 =
* added Olis_Breadcrumbs_Updates class and db update procedure
* added WPBakery elements support

= 0.1.4 =
* added Divi module

= 0.1.3 =
* added widget

= 0.1.2 =
* reorganized files

= 0.1.1 =
* added Archives link, made exclude-home default to true
* fix raw html when in a subcategory

= 0.1 =
* created [breadcrumbs] shortcode
