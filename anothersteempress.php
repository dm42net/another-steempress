<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             0.5.0
 * @package           AnotherSteempress
 *
 * @wordpress-plugin
 * Plugin Name:       Another Steempress
 * Description:       A cross-posting utility to post your WORDPRESS posts to the STEEM Blockchain
 * Version:           0.8.4
 * Author:            DM42.Net
 * Author URI:        https://www.dm42.net/anothersteempress/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       anothersteempress
 * Domain Path:       /languages
 *
 * An extension of work done by Martin Lees, https://steemit.com/@howo
 *
 *
 ****************************************************************************************************************************************
    AnotherSteempress Wordpress Plugin - submit WordPress posts and pages
    to the Steem Blockchain.
    Copyright (C) 2018 Matthew T. Dent
    Portions Copyright (C) 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.

 ****************************************************************************************************************************************
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'anotheranothersteempress_compte', '0.5.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-anothersteempress-activator.php
 */
function activate_anothersteempress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anothersteempress-activator.php';
	AnotherSteempress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-anothersteempress-deactivator.php
 */
function deactivate_anothersteempress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-anothersteempress-deactivator.php';
	AnotherSteempress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_anothersteempress' );
register_deactivation_hook( __FILE__, 'deactivate_anothersteempress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-anothersteempress.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_anothersteempress() {

	$plugin = new AnotherSteempress();
	$plugin->run();

}
run_anothersteempress();
