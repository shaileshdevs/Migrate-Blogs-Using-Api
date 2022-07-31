<?php
/**
 * Include all the necessary files.
 *
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include the class to create custom post type 'Article'.
require_once 'includes/class-article-custom-post-type.php';
\MBUA\Article_Custom_Post_type::get_instance();

// Load only when backend page or an Ajax request.
if ( is_admin() || defined( 'DOING_AJAX' ) ) {
	// Include the class for sub menu 'Fetch Authors and Articles' under 'Articles' menu.
	require_once 'includes/admin/class-fetch-authors-articles-sub-menu.php';
	\MBUA\Admin\Fetch_Authors_Articles_Sub_Menu::get_instance();

	// Include the class for custom user fields.
	require_once 'includes/admin/class-user-custom-fields.php';
	\MBUA\Admin\User_Custom_Fields::get_instance();
}
