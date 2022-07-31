<?php
/**
 * 'Fetch Authors and Articles' Sub Menu.
 *
 * @since 1.0.0
 */

namespace MBUA\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Fetch_Authors_Articles_Sub_Menu' ) ) {
	/**
	 * Handle fetching authors and articles using API.
	 *
	 * @since 1.0.0
	 */
	class Fetch_Authors_Articles_Sub_Menu {
		/**
		 * This class's instance.
		 *
		 * @since 1.0.0
		 *
		 * @var Fetch_Authors_Articles_Sub_Menu Singleton instance of the class.
		 */
		private static $instance = null;

		/**
		 * User/ author identification meta key.
		 *
		 * @since 1.0.0
		 *
		 * @var string Value is 'mbua_user_source'.
		 */
		private $mbua_user_identification_meta_key = 'mbua_user_source';

		/**
		 * User/ author identification meta value.
		 *
		 * @since 1.0.0
		 *
		 * @var string Value is 'https://jsonplaceholder.typicode.com/users/'.
		 */
		private $mbua_user_identification_meta_value = 'https://jsonplaceholder.typicode.com/users/';

		/**
		 * Return the single instance of the class.
		 *
		 * @since 1.0.0
		 *
		 * @return Fetch_Authors_Articles_Sub_Menu Return instance of the class Fetch_Authors_Articles_Sub_Menu.
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * Constructor.
		 */
		private function __construct() {
			// Register the sub menu 'Fetch Authors and Articles'.
			add_action( 'admin_menu', array( $this, 'register_sub_menu' ) );

			// Enqueue scripts and styles.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts_styles' ) );

			// Attach Ajax callback to fetch authors request.
			add_action( 'wp_ajax_mbua_fetch_authors_action', array( $this, 'fetch_authors_action' ) );
			
			// Attach Ajax callback to fetch articles request.
			add_action( 'wp_ajax_mbua_fetch_articles_action', array( $this, 'fetch_articles_action' ) );
		}

		/**
		 * Register the sub menu for 'Fetch Authors and Articles'.
		 *
		 * Callback to action 'admin_menu'.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function register_sub_menu() {
			// Register the sub menu 'Fetch Authors and Articles'.
			add_submenu_page( 'edit.php?post_type=articles', __( 'Fetch Users & Articles', 'mbua-migrate-blogs' ), __( 'Fetch Users & Articles', 'mbua-migrate-blogs' ), 'manage_options', 'fetch_articles', array( $this, 'display_content' ) );
		}

		/**
		 * Display the content or settings on 'Fetch Authors and Articles' sub menu.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function display_content() {
			include_once MBUA_DIR_PATH . 'templates/admin/fetch-articles-sub-menu.php';
		}

		/**
		 * Enqueue scripts and styles on 'Fetch Authors and Articles' page.
		 *
		 * Callback to action 'admin_enqueue_scripts'.
		 *
		 * @since 1.0.0
		 * @param string $hook_suffix The current admin page.
		 *
		 * @return void
		 */
		public function enqueue_admin_scripts_styles( $hook_suffix ) {
			if ( 'articles_page_fetch_articles' != $hook_suffix ) {
				return;
			}

			wp_enqueue_script(
				'mbua-fetch-articles-authors-js',
				MBUA_DIR_URI . 'assets/admin/fetch-articles-authors.js',
				array( 'jquery' ),
				filemtime( MBUA_DIR_PATH . 'assets/admin/fetch-articles-authors.js' ),
				true
			);
		}

		/**
		 * Add the authors from the external site using API.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function fetch_authors_action() {
			$response = array(
				'status'  => 'FAILURE',
				'message' => __( 'You are not authorized to perform this action.', 'mbua-migrate-blogs' ),
			);

			// Verify nonce.
			if ( false === check_ajax_referer( 'mbua_fetch_authors_action', 'mbua_nonce' ) ) {
				// Nonce is not valid, send response and die.
				wp_send_json( $response );
			}

			/**
			 * Check user capability.
			 * Only admin has an authorization to fetch the authors from external site.
			 */
			if ( ! current_user_can( 'manage_options' ) ) {
				// User doesn't have the capability, send response and die.
				wp_send_json( $response );
			}

			// Process request.
			// Validate the URL to avoid redirection and request forgery attacks, and get the response.
			$res = wp_safe_remote_get( 'https://jsonplaceholder.typicode.com/users/' );

			// If failure occurs on request.
			if ( $res instanceof WP_Error ) {
				$response['message'] = __( 'Internal server error. Try again later.', 'mbua-migrate-blogs' );
				// Internal server error, send response and die.
				wp_send_json( $response );
			}

			$authors_data        = json_decode( $res['body'], true );
			$no_of_users_added   = 0;
			$no_of_users_skipped = 0;

			foreach ( $authors_data as $author_data ) {
				if ( email_exists( $author_data['email'] ) || username_exists( $author_data['username'] ) ) {
					// If email or username already exists.
					$no_of_users_skipped++;
				} else {
					// If username and email doesn't exist.
					$user_id = wp_insert_user(
						array(
							'user_email'   => $author_data['email'],
							'user_login'   => $author_data['username'],
							'display_name' => $author_data['name'],
							'user_pass'    => wp_generate_password( 12, false ),
							'role'         => 'author',
						)
					);

					update_user_meta( $user_id, 'mbua_address_street', $author_data['address']['street'] );
					update_user_meta( $user_id, 'mbua_address_suite', $author_data['address']['suite'] );
					update_user_meta( $user_id, 'mbua_address_city', $author_data['address']['city'] );
					update_user_meta( $user_id, 'mbua_address_pincode', $author_data['address']['zipcode'] );
					update_user_meta( $user_id, 'mbua_phone', $author_data['phone'] );
					update_user_meta( $user_id, 'mbua_company_name', $author_data['company']['name'] );
					update_user_meta( $user_id, 'mbua_website', $author_data['website'] );
					update_user_meta( $user_id, User_Custom_Fields::get_user_identification_meta_key(), User_Custom_Fields::get_user_identification_meta_value() );

					$no_of_users_added++;
				}
			}

			$response['status'] = 'SUCCESS';
			/* translators: %1$d: Number of user added %2$s: Number of user skipped */
			$response['message'] = sprintf( __( 'Users added: %1$d, Users Skipped: %2$d', 'mbua-migrate-blogs' ), $no_of_users_added, $no_of_users_skipped );

			// Send response and die.
			wp_send_json( $response );
		}

		/**
		 * Add the articles from the external site using API.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function fetch_articles_action() {
			$response = array(
				'status'  => 'FAILURE',
				'message' => __( 'You are not authorized to perform this action.', 'mbua-migrate-blogs' ),
			);

			// Verify nonce.
			if ( false === check_ajax_referer( 'mbua_fetch_articles_action', 'mbua_nonce' ) ) {
				// Nonce is not valid, send response and die.
				wp_send_json( $response );
			}

			/**
			 * Check user capability.
			 * Only admin has an authorization to fetch the articles from external site.
			 */
			if ( ! current_user_can( 'manage_options' ) ) {
				// User doesn't have the capability, send response and die.
				wp_send_json( $response );
			}

			// Process request.
			// Validate the URL to avoid redirection and request forgery attacks, and get the response.
			$res = wp_safe_remote_get( 'https://jsonplaceholder.typicode.com/posts/' );

			// If failure occurs on request.
			if ( $res instanceof WP_Error ) {
				$response['message'] = __( 'Internal server error. Try again later.', 'mbua-migrate-blogs' );
				// Internal server error, send response and die.
				wp_send_json( $response );
			}

			$articles_data = json_decode( $res['body'], true );

			// Contains the article Ids created.
			$article_ids = array();

			// Get the authors added from the external site using API.
			$authors_id = get_users(
				array(
					'meta_key'   => User_Custom_Fields::get_user_identification_meta_key(),
					'meta_value' => User_Custom_Fields::get_user_identification_meta_value(),
					'fields'     => 'ID',
				)
			);

			/**
			 * Single author Id whom the articles will be assigned.
			 * If no author is found, articles will be assigned to an admin.
			 */
			$author_id = empty( $authors_id ) ? 1 : $authors_id[0];

			foreach ( $articles_data as $article_data ) {
				$post_type = class_exists( '\MBUA\Article_Custom_Post_type' ) ? \MBUA\Article_Custom_Post_type::get_post_type() : 'articles';

				// Add an article.
				$article_ids[] = wp_insert_post(
					array(
						'post_type'    => $post_type,
						'post_author'  => $author_id,
						'post_title'   => $article_data['title'],
						'post_content' => $article_data['body'],
						'post_status'  => 'publish',
					)
				);
			}

			$response['status'] = 'SUCCESS';
			/* translators: %s: Article Ids separated by comma */
			$response['message'] = sprintf( __( 'Created Article Ids: %s', 'mbua-migrate-blogs' ), implode( ', ', $article_ids ) );

			// Send response and die.
			wp_send_json( $response );
		}
	}
}
