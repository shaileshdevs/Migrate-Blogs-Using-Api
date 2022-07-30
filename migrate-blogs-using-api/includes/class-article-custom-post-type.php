<?php
/**
 * Article Custom Post Type.
 *
 * @since 1.0.0
 */

namespace MBUA;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Article_Custom_Post_type' ) ) {
    /**
     * Handle Article custom post type.
     *
     * @since 1.0.0
     */
    class Article_Custom_Post_type {
        /**
		 * This class's instance.
		 *
		 * @since 1.0.0
		 *
		 * @var Article_Custom_Post_type Singleton instance of the class.
		 */
		private static $instance = null;

        /**
		 * Constructor.
		 */
		private function __construct() {
            add_action( 'init', array( $this, 'register_article_post_type' ) );
		}

        /**
		 * Return the single instance of the class.
		 *
		 * @since 1.0.0
		 *
		 * @return Article_Custom_Post_type Return instance of the class Article_Custom_Post_type.
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

        /**
         * Return the custom post type, here: articles.
         *
         * @since 1.0.0
         *
         * @return string Return custom post type. Here: articles.
         */
        public static function get_post_type() {
            return 'articles';
        }

        /**
         * Register the custom post type Article.
         *
         * @since 1.0.0
         *
         * @return void
         */
        public function register_article_post_type() {
            $post_type = Article_Custom_Post_type::get_post_type();

            // Register post type.
            register_post_type( $post_type,
                array(
                    'labels'       => array(
                        'name'          => __( 'Articles', 'mbua-migrate-blogs' ),
                        'singular_name' => __( 'Article', 'mbua-migrate-blogs' ),
                    ),
                    'public'       => true,
                    'has_archive'  => true,
                    'show_in_rest' => true,
                    'menu_icon'    => 'dashicons-welcome-write-blog',
                    'supports'     => array(
                        'title',
                        'editor',
                        'author',
                    ),
                )
            );
        }
    }
}
