<?php
/**
 * Plugin Name:       Migrate Blogs Using API
 * Plugin URI:        https://example.com/plugins/migrate-blogs
 * Description:       Allows to copy the blogs from other site using API to the current WordPress site.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Shailesh Vishwakarma
 * Author URI:        https://github.com/shaileshdevs
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mbua-migrate-blogs
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'MBUA_DIR_PATH' ) ) {
	define( 'MBUA_DIR_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'MBUA_DIR_URI' ) ) {
	define( 'MBUA_DIR_URI', plugin_dir_url( __FILE__ ) );
}

// Include the files.
require_once 'include-files.php';
