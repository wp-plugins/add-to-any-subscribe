=== Add to Any Subscribe Button ===
Contributors: micropat
Donate link: http://www.addtoany.com/contact/
Tags: widget, sidebar, rss, plugin, links, feed, feeds, images, button, posts, subscribe, add to any, addtoany, add, any, email, e-mail, Google, My, Yahoo, Mixx, iTunes, Feeds
Requires at least: 2.2
Tested up to: 2.6
Stable tag: 0.9.1

Lets readers subscribe to your blog using any feed reader.

== Description ==

Lets readers **subscribe** to your blog using **any feed reader**, such as Google Reader, My Yahoo!, Netvibes, Pageflakes, and all the rest.  The button comes with Add to Any's customizable Smart Menu, which **places the services visitors use at the top of the menu**, based on each visitor's browsing history.

* Add to Any Smart Menu
* Includes all services
* Services updated automatically
* Searchable on key-down
* Keyboard navigation
* Google Analytics integration

Demo: <a href="http://www.addtoany.com/" title="Subscribe, Share, Save buttons">http://www.addtoany.com/</a>

See also, the <a href="/extend/plugins/add-to-any/">Share/Save/Bookmark button</a> plugin.

== Installation ==

1. Upload `add-to-any-subscribe` to the `/wp-content/plugins/` directory
1. Activate the plugin through the `Plugins` menu in WordPress
1. Go to `Presentation` -> `Widgets` and click `Add` next to "Add to Any Subscribe"

= How often is the list of services updated? =

Constantly.

= Where can I choose which button to display and other options? =

Go to `Presentation` > `Widgets`.  Under `Current Widgets`, look for "Add to Any Subscribe", and click `Edit`.

= How come the widget doesn't display once I activate it? =

You'll have to manually put it where you want it in your sidebar.  You can do so by going to `Presentation` > `Widgets` and clicking `Add` next to "Add to Any Subscribe".  You'll need to have a "widget ready" theme.

If you have already added the widget but the actual button is not displaying, you should reinstall the widget, making sure to copy the actual `add-to-any-subscribe` folder (and all of its contents) to your plugins folder.

Also, be sure to deactivate any previous versions of the widget in the `Plugins` tab.

= What if I don't have a "widget ready" theme, or I want to place the button somewhere else? =

Using the Theme Editor, you can place the following code in your template pages (within sidebar.php, index.php, single.php, and/or page.php):

`&lt;?php Add_to_Any_Subscribe_Widget::display(); ?&gt;`

== Screenshots ==

1. This is the Add to Any Subscribe button!
2. This is the drop-down menu that appears instantly when visitors move the mouse over the Subscribe button!