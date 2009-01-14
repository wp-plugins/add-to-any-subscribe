=== Add to Any Subscribe Button ===
Contributors: micropat
Donate link: http://www.addtoany.com/contact/
Tags: widget, sidebar, rss, plugin, links, feed, feeds, images, admin, button, Post, posts, subscribe, add to any, addtoany, add, any, email, e-mail, mobile, Google, My, Yahoo, Mixx, iTunes, Feeds
Requires at least: 2.2
Tested up to: 2.7
Stable tag: 0.9.6

Helps readers subscribe to your blog using any feed reader or feed emailer.

== Description ==

Helps readers **subscribe** to your blog using **any feed reader**, such as Google Reader, My Yahoo!, Netvibes, Windows Live, and all the rest.  The button comes with Add to Any's customizable Smart Menu, which **places the services visitors use at the top of the menu**, based on each visitor's browsing history.

* Add to Any Smart Menu
* Includes all services
* Services updated automatically
* WordPress optimized
* Searchable on key-down
* Keyboard navigation
* Many more publisher and user features

<a href="http://www.addtoany.com/" title="Subscribe button and sharing button">Demo</a> | <a href="other_notes/">Changelog</a>

See also, the <a href="/extend/plugins/add-to-any/">Share/Save/Bookmark button</a> plugin.

== Installation ==

1. Upload the `add-to-any-subscribe` directory (including all files within) to the `/wp-content/plugins/` directory
1. Activate the plugin through the `Plugins` menu in WordPress
1. Go to `Presentation` -> `Widgets` and click `Add` next to "Add to Any Subscribe"

== Frequently Asked Questions ==

= How often is the list of services updated? =

Constantly.

= Where can I choose which button to display and other options? =

Go to `Settings` > `Subscribe Buttons`. 

= How come the widget doesn't display once I activate it? =

You'll have to manually put it where you want it in your sidebar.  You can do so by going to `Presentation` > `Widgets` and clicking `Add` next to "Add to Any Subscribe".  You'll need to have a "widget ready" theme.

If you have already added the widget but the actual button is not displaying, you should reinstall the widget, making sure to copy the actual `add-to-any-subscribe` folder (and all of its contents) to your plugins folder.

Also, be sure to deactivate any previous versions of the widget in the `Plugins` tab.

= What if I don't have a "widget ready" theme, or I want to place the button somewhere else? =

Using the Theme Editor, you can place the following code in your template pages (within sidebar.php, index.php, single.php, and/or page.php):

`<?php Add_to_Any_Subscribe_Widget::display(); ?>`

= Why isn't the drop-down menu appearing? =

It's likely because your your theme wasn't <a href="http://codex.wordpress.org/Theme_Development#Plugin_API_Hooks" target="_blank">coded properly</a>.  Using the Theme Editor, make sure that the following piece of code is included in your theme's `footer.php` file just before the `</body>` line:

`<?php wp_footer(); ?>`

= How can I customize the feed of the widget? (Useful for comment feeds, category feeds, etc.) =

This can be done through the template tag (as described above).  Simply supply a feed name and feed URL through the template tag like so:

`<?php if( class_exists('Add_to_Any_Subscribe_Widget') ) {
	$A2A_SUBSCRIBE_options = array(
		"feedname" => "Name of the Feed",
		"feedurl" => "http://www.example.com/feed");
	Add_to_Any_Subscribe_Widget::display( $A2A_SUBSCRIBE_options );
} ?>`

= Why do embedded objects (like Flash) disappear when the menu is displayed? =

This is done to overcome browser limitations that prevent the drop-down menu from displaying on top of intersecting embedded objects.  If you would like to disable this, uncheck the `Hide embedded objects (Flash, video, etc.) that intersect with the menu when displayed` option on the plugin's settings page.

== Screenshots ==

1. This is the Add to Any Subscribe button
2. This is the drop-down menu that appears instantly when visitors move the mouse over the Subscribe button
3. This is the drop-down menu showing the services available to the user within the Subscribe menu.  Services are constantly added/updated.

== Changelog ==

.9.6:

* Widget title option
* Text-only button stripslashes

.9.5.5.6:

* Chinese translation updated

.9.5.5.5:

* i18n
* Chinese translation
* Installation clarified

.9.5.5.4:

* WordPress 2.7 admin styling
* Settings link on Plugins page
* Basename var

.9.5.5.3:

* Less JavaScript redundancy from Additional Options (saves bandwidth)
* Compressed PNGs added, select a button from settings to begin using PNG (saves bandwidth)

.9.5.5.2:

* Additional Options in Admin panel provides link to JavaScript API
* Option to have full addtoany.com legacy page open in a new window

.9.5.5.1:

* Replaced short form of PHP's open tags with long form to work around configurations with short_open_tag disabled

.9.5.5:

* Accomodates renamed plugin directory

.9.5.4:

* Fixed a small syntax error (critcal if you're on .9.5.3)

.9.5.3:

* Language & localization update

.9.5.2:

* Event attributes removed (JS now takes care of button events)
 * This eliminates the chance of errors prior to JS fully loading

.9.5.1:

* Fixed repo problem

.9.5:

* Supports custom feeds using through template tag
* Updated template tag to prevent PHP errors when deactivating plugin
* For XHTML validation, special characters are converted to HTML entities within JavaScript variables
* Reprioritized plugin to load later
* Text-only button option

.9.4:

* Internationalization
* Buttons updated

.9.3:

* Moved external JavaScript to bottom so that content is prioritized over HTTP requests to static.addtoany.com
 * Please note that some improperly-coded themes may prevent this from working. See the FAQ entry for "Why isn't the drop-down menu appearing?" if this is the case.
* Added support to better conform to widget-ready themes
* Fixed markup generation to support list containers and ensure W3C validation

.9.2.2:

* Fixed bug in Internet Explorer 6 that caused custom buttons to have a height and width of 0
* Removed the XHTML depreciated `name` attribute from the button's anchor

.9.2.1:

* Fixed 1 line to support those without short_open_tag

.9.2:

* New: Custom buttons (specify a URL)
* Fix to permit XHTML Strict validation

.9.1:

* New Menu Styler lets you customize the color of the menus
* New Menu Option: "Only show the menu when the user clicks the Subscribe button"
* New additional customization: Set custom JavaScript variables
* Simplified config panel in `Design` > `Widgets` with link to `More Settings...`
* New full settings panel in: `Settings` > `Subscribe Buttons`
* Better support for CSS styling: .addtoany_share_save
* PHP support for short_open_tag
* PHP4 legacy and compatibility fixes