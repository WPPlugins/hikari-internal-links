<?php
/*
Plugin Name: Hikari Internal Links
Plugin URI: http://Hikari.ws/internal-links/
Description: Hikari Internal Links provides a shortcode that dynamically generates to most Wordpress pages, like posts, comments, categories, feeds.
Version: 0.06.03
Author: Hikari
Author URI: http://Hikari.ws
*/

/**!
* Thanks to http://www.toppa.com/post-to-post-links-wordpress-plugin and
* http://coffee2code.com/wp-plugins/easy-post-to-post-links/
* for their original work.
*
* I, Hikari, from http://Hikari.WS , and the original author of the Wordpress plugin named
* Hikari Internal Links, please keep this license terms and credit me if you redistribute the plugin
*
*
*
*   This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*
/*****************************************************************************
* © Copyright Hikari (http://wordpress.Hikari.ws), 2010
* If you want to redistribute this script, please leave a link to
* http://hikari.WS
*
* Parts of this code are provided or based on ideas and/or code written by others
* Translations to different languages are provided by users of this script
* IMPORTANT CONTRIBUTIONS TO THIS SCRIPT (listed in alphabetical order):
*
** Michael Toppa @ http://www.toppa.com/post-to-post-links-wordpress-plugin
** Scott Yang @ http://scott.yang.id.au/file/js/rot13.js
** Scott Reilly @ http://coffee2code.com/wp-plugins/easy-post-to-post-links/
*
* Please send a message to the address specified on the page of the script, for credits
*
* Other contributors' (nick)names may be provided in the header of (or inside) the functions
* SPECIAL THANKS to all contributors and translators of this script !
*****************************************************************************/

define('HkInLink_basename',plugin_basename(__FILE__));
define('HkInLink_pluginfile',__FILE__);


require_once 'hikari-tools.php';
require_once 'hikari-internal-links-core.php';

