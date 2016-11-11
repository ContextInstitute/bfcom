=== Debug This  ===
Tags: debug, debugger, print_r, var_dump, developer, tool, tools, debug tool, debug tools, debugger tool, debugger tools
Contributors: misternifty, cdillon27
Tested up to: 4.3
Requires at least: 3.3
Stable Tag: trunk
License: GPLv2 or later

This plugin gives WordPress super admins an easy way to peek under the hood of the front-face of a WordPress installation via the admin bar.

== Description ==
This plugin gives WordPress super admins an easy way to peek under the hood of the front-face of a WordPress installation via the admin bar.

Forty-nine debug modes are included. Here is a sample of the packed-in debug goodness:

* oEmbed providers
* Post attachments
* Variety of WP_Query modes
* Variety of PHP modes (defined functions, constants, classes, phpinfo, etc...)
* Users (Current author, all users)
* Cron
* Cache
* Registered image sizes
* Post types
* Menus, Widgets, Sidebars
* Rendered page analysis (CSS, JS, Images)
* Many more!

Debug This helps you minimize effort when trying to surface WP/PHP/Server data. Instead of hardcoding debug snippets or writing complex unit
tests for small functionality, you can simply surface what you need right from the admin bar. If there's not a debug mode that addresses your need,
create one with the functional Debug This API.

To extend Debug This for your own needs, please see the [Extend section](http://wordpress.org/extend/plugins/debug-this/other_notes/).

== Installation ==

1. Upload to your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen.
3. Navigate to the front-end of your website and hover over the 'Debug This' menu item in the admin bar.

== Frequently Asked Questions ==

**How do I use Debug This?**

1. Make sure the admin bar is enabled in your user profile for the front-facing view of your website.
2. Visit any page/post/archive on your website and you will see a Debug This menu item on the admin bar.


**What PHP version is this compatible with?**

We've tested on PHP >= 5.2.17

**Can we request new debug modes?**

Certainly! Contact me [here](https://www.wpmission.com/contact). I reserve the right to deny any requests that are too
localized for the greater good. If that is the case, I will help guide you how to build your own debug mode.


**Can I alter the plugin or build my own debug modes?**

Yes! Visit the [Extend section](http://wordpress.org/extend/plugins/debug-this/other_notes) to find out how you can thoroughly extend Debug This for your own needs.

**Why did you build Debug This?**

I was working on a large collaborative project with 20+ developers and I got weary of debugging leftover debug code.
I wanted a way to surface the data we needed without having to hardcode debugging code. Debug This keeps assurances that no debug code makes it up to a production environment.

== Screenshots ==

1. This shows the modes navigation menu
2. Example mode - Attachments
3. Example mode - WP_DEBUG mode
4. Example mode - Queried Object
5. Example mode - bloginfo()

== Extend ==

= Debug This Functions =

New debug modes can be created easily:

`
add_debug_extension(
	$mode,
	$menu_label,
	$description,
	$callback,
	$group = 'General'
);
`

**Example**

`
add_debug_extension(
	'actions',
	__('Actions', 'debug-this'),
	__('$wp_actions contains all active registered actions', 'debug-this'),
	'foo_callback',
	'Filters And Actions'
);
function foo_callback($buffer, $template){
	global $wp_actions;
	$debug = print_r($wp_actions, true);
	return $debug;
}
`

You can add links to the header of a debug mode page. Place this code within your debug callback function.

`add_debug_header_link('http://urltolink', 'Link Label');`


Extensions can be removed as well using `remove_debug_extension($mode);`


**No PRE Tags**

If you don't want your debug output to be enclosed in PRE tags, simply set the following in your extension:

`Debug_This::$no_pre = true;`

**Saved Queries and Execution Time**

Retrieve saved queries and execution time by using the following static properties:

* `Debug_This::$execution_time`
* `Debug_This::$queries` - SAVEQUERIES must defined as true

**URL Helpers**

* `Debug_This::get_current_debug_url()` - current URL with the debug query
* `Debug_This::get_escape_url()` - used for the debug escape link that links to original page URL

= WP Actions =

* `debug_this` - receives the $mode arg - outputs the debug code sent from the extension modes. The default action is set to priority 5. This allows you to prepend or append any output without conflict using less or greater priorities.

= WP Filters =

There are a few filters you can use to customize Debug This to your needs:

* `debug_this_template` - receives $template arg - Use your own template
* `debug_this_default_mode`  - receives $mode arg - Alters the mode for the parent DT admin bar button link.
* `debug_this_output` - receives $output, $mode args - Filter debug content before it's rendered


= JavaScript =

To access the built-in Debug This JS functionality, enqueue your custom script with the dependency set to `debug-this`. Your script will inherit a jQuery dependency.

**Object: debugThis**

* `debugThis.mode` - current mode
* `debugThis.defaultMode`
* `debugThis.template` - current included template
* `debugThis.queryVar` - the defined query string variable

**Functions:**

* `isDebug()`
* `getDebugMode()` - uses `isDebug()`

**Events:**

A jQuery `debug-this` event is fired from the footer. You can hook into this event with the following;
`
jQuery(document).bind('debug-this', function(event, debugThis){
	console.log(debugThis);
});
`

= Helper Functions =

There are three included functions to help you work with files.

* `debug_this_get_file_ownership($file)` - returns `array('name' => $name, 'group' => $group)`
* `debug_this_get_file_perms($file)` - returns string - Example: 0775
* `debug_this_convert_perms_to_rwx($perms)` - returns string - converts permission number to RWX format - Example: 0755 folder becomes drwxr-xr-x


== Changelog ==

= 0.4 - August 29, 2015 = 
* Fix display of global array variables.
* Fix display of current template.
* Fix use of a deprecated function.

= 0.3.2 - April 17, 2015 =
* Improve SAVEQUERIES check.

= 0.3.1 - March 17, 2015 =

* Fix non-static method call. Thanks [Daniele "Mte90" Scasciafratte](https://wordpress.org/support/profile/mte90).
* Fix output for TwentyFifteen theme.
* Replace close button "X" with Dashicon.

= 0.3 =

* Added advanced remote fetch for buffer
* Added real saved queries and execution time from original URL - can now be accessed as static properties $queries and $execution_time
* Added `get_current_debug_url()` method - exposes current URL with debug query
* Added post-meta debug mode. Created new menu section for queried object
* Updated bloginfo mode to true bloginfo values
* Updated wp-debug mode with better logic
* Added functionality for adding header links to the debug mode screen via `add_debug_header_link($url, $label, $classes = '')`
* Added reset debug log functionality with debug header link for wp-debug mode

= 0.2.2 =

* Added backwards compatibility to 3.3.
* Added support for no pretty permalinks.

= 0.2.1 =

* Critical fix for PHP <= 5.2 Removed anonymous functions.
* Fixed undefined $debug notices for all versions.

= 0.02 =

* Added new debug modes: Apache modules, PHP loaded extensions, file permissions, php.ini, $_SERVER, and execution time.
* Added three functions for getting file ownership and permissions
	* `debug_this_get_file_ownership($file)`
	* `debug_this_get_file_perms($file)`
	* `debug_this_convert_perms_to_rwx($perms)`

= 0.01 =

* Debug This Creation

== Upgrade notice ==

Fix display of global array variables. Fix display of current template. Fix use of a deprecated function.
