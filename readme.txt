=== JM Dashicons Shortcode ===
Contributors: jmlapam
Donate Link: http://www.amazon.fr/registry/wishlist/1J90JNIHBBXL8
Tags: dashicons, font icon, icon font, icons, ui
Tested up to: 3.9.1
Requires at least: 3.9.1
License: GPLv2 or later
Stable tag: trunk
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easy integration of Dashicons font in posts !

== Description ==

WordPress 3.8 known as Oscar offers an amazing font, Dashicons, this plugins allows you to use it for your posts.

Once activated the plugin adds a shortcode in edit post. You can now enjoy Dashicons font added to the core in WordPress 3.8 to do what you want e.g page sections with icons.
The plugin adds a popup buton on visual editor so you can set it in WYSIWYG. Hit the help tab to get full list on widget and menu pages.

Shortcode is available on posts, widgets and nav menus (see <a href="http://www.tweetpress.fr" title="TweetPress - WordPress & Twitter stuffs">example on my blog</a>)

<a href="http://twitter.com/intent/user?screen_name=tweetpressfr">Follow me on Twitter</a>


== Installation ==

1. Upload plugin files to the /wp-content/plugins/ directory
2. Activate the plugin through the Plugins menu in WordPress
3. Then go to your post edit and just use the shortcode e.g `[dashicon name="smartphone" size="3" color="#f83123" class="myclass"]`
4. The plugin adds a **FULL LIST of available icons** with their name on tinymce button
5. You can easily know how to write the shortcode with quicktag buttons ( go the HTML tab in your edit post)

== Frequently asked questions ==

= Where can I find the name for icons? =

On post edits use the admin UI (tinymce to set your icon)
On widget and menu pages you have a help button (on the top right of the screen), when clicking on this button it slides a pannel with multiple tabs. You'll find all the icons available.

= If you care about accessibility =

Just use the text parameter like this :
`[dashicon name="twitter" text="share on Twitter"]`

It won't change anything for you but it can improve experience for people using assistive technologies such as VoiceOver

= The text for accessibility is showing =

That's too bad. Maybe your theme missed it. To avoid this just put the following code in your CSS :

`
.screen-reader-text {
   	position: absolute;
	left: -7000px;
	overflow: hidden;
}
`

= The font does not appear on IE8 =

You might add some stylesheet for IE8 and put in here : 

`
.ds-fallback-text .dashicons:before { content: ''; }
`

Then you might add a little bit of JavaScript.

= Some icons do not show up =

Please check you WP version, Dashicons have been updated with WP 3.9

= I want to write a shortcode in a widget text but not to execute it =

The plugin activates shortcodes in widget text.
In this very very particular case, you can use this great trick : put the shortcode in double [] like that :
`
[[myshortcode]]
`

<a href="http://www.geekpress.fr/wordpress/astuce/execution-shortcode-article-1864/">Source</a>


== Screenshots ==

1. help button
2. lists of icons
3. quicktags
4. menu with icons

== Changelog ==

= 1.7.2 =
* 14 May 2014
* fix array for arg color that triggers notice
* Remove extract from shortcode callback according to this trac : https://core.trac.wordpress.org/ticket/22400

= 1.7.1 =
* 02 May 2014
* Fix wrong file for widgetize function
* Localize tinymce popup
* Add admin UI (tinymce button for better UX)
* Be careful some of the icons won't work if you use older versions of WordPress
* Remove conditional load of dashicons.min.css , while it was good for performance it is not compatible with menu use

= 1.6 =
* 17 Apr 2014
* Add new dashicons available in 3.9
* Add help tabs in widgets page
* https://github.com/melchoyce/dashicons/commit/0158c5fb7e17ba71b9cdbb521dcc15efebdeaee9

= 1.5 =
* 09 Mar 2014
* Include is_a() as test to avoid bad warning on 404 and achives - (props to juliobox)

= 1.4.3 =
* 12 Feb 2014
* Add filter for developers, if you want to modify or disable this just use `add_filter('jmds_markup', 'your_callback');`
* delete useless quicktags, if you need less parameters then delete them from shortcode 
* Add a footage to explain how the plugin works

= 1.4.2 =
* 09 Feb 2014
* Add tutorial to FAQ especially for IE8
* Add screenshot (menu with icon)
* Replace int values with float values which should allow you to use more precise dimensions
* Fix wrong capability name edit_posts instead of edit_post

= 1.4.1 =
* 06 Feb 2014
* Add CSS code to FAQ in case your theme missed the .screen-reader-text class
* Prevent size from being screwed by decimal

= 1.4 =
* 04 Feb 2014
* Try to make font icon more accessible with new parameter text, if you do not use it will grab font icon name.

= 1.3 =
* 03 Feb 2014
* Fix wrong way to comment in inline CSS 
* Add more precise description for icons (shortcode)

= 1.2 =
* 03 Feb 2014
* Add custom pointer for helper tab

= 1.1 =
* 03 Feb 2014
* Add has_shortcode() to optimize loading

= 1.0 =
* 31 Jan 2014
* Initial upload

