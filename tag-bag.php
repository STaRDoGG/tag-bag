<?php
/*
Plugin Name: Tag Bag
Plugin URI: https://github.com/STaRDoGG/tag-bag
Description: Extended Tagging for WordPress 4.0.x : Suggested Tags, Mass edit tags, Auto-tags, Autocompletion, Related Posts etc. NOW Compatible custom post type and custom taxonomy!
Version: 2.4
Author: J. Scott Elblein
Author URI: http://geekdrop.com
Text Domain: tagbag

Copyright 2014 - J. Scott Elblein

Fork of the Simple Tags plugin by Amaury BALMER, who did the bulk of the plugin, I've just extended it a bit.

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

Contributors:
	- Kevin Drouvin (kevin.drouvin@gmail.com - http://inside-dev.net)
	- Martin Modler (modler@webformatik.com - http://www.webformatik.com)
	- Vladimir Kolesnikov (vladimir@extrememember.com - http://blog.sjinks.pro)

Credits Icons :
	- famfamfam - http://www.famfamfam.com/lab/icons/silk/

Todo:
	Both:
	Add option to add list of words to ignore when auto tagging (i.e. why, the, in, to, them, common, meaningless words, etc.). Pretty simple to add, just use an array.

	Admin:
	Client:
*/

// No direct access
if ( !defined('ABSPATH') )
	die('-1');

// Do a PHP version check, requires 5.0 or newer
if (version_compare(PHP_VERSION, '5.0.0', '<') ) {
	// Silently deactivate plugin, keeps admin usable
	if( function_exists('deactivate_plugins') ) {
		deactivate_plugins(plugin_basename(__FILE__), true);
	}

	// Spit out die messages
	wp_die(sprintf(__('Your PHP version is too old, please upgrade to a newer version. Your version is %s, Tag Bag requires %s. Remove the plugin from WordPress plugins directory with a FTP client.', 'tagbag'), phpversion(), '5.0.0'));
}

define( 'TAGB_VERSION','2.4' );
define( 'TAGB_OPTIONS_NAME','tagbag' );								// Option name for save settings
define( 'TAGB_OPTIONS_NAME_AUTO','tagbag-auto' );			// Option name for save settings auto terms

define ( 'TAGB_URL', plugins_url('', __FILE__) );
define ( 'TAGB_DIR', rtrim(plugin_dir_path(__FILE__), '/') );

require( TAGB_DIR . '/inc/functions.inc.php');				// Internal functions
require( TAGB_DIR . '/inc/functions.deprecated.php');	// Deprecated functions
require( TAGB_DIR . '/inc/functions.tpl.php');				// Templates functions

require( TAGB_DIR . '/inc/class.plugin.php');
require( TAGB_DIR . '/inc/class.client.php');
require( TAGB_DIR . '/inc/class.client.tagcloud.php');
require( TAGB_DIR . '/inc/class.widgets.php');

// Activation, uninstall
register_activation_hook(__FILE__, array('tagbag_Plugin', 'activation'));
register_deactivation_hook(__FILE__, array('tagbag_Plugin', 'deactivation'));

// Init Tag Bag
function init_tag_bag() {
	// Load client
	new tagbag_Client();
	new tagbag_Client_TagCloud();

	// Admin and XML-RPC
	if ( is_admin() ) {
		require( TAGB_DIR . '/inc/class.admin.php' );
		new tagbag_Admin();
	}

	add_action( 'widgets_init', create_function('', 'return register_widget("tagbag_Widget");') );
}
add_action( 'plugins_loaded', 'init_tag_bag' );