<?php
/**
 * User Custom Fields.
 *
 * @since 1.0.0
 */

namespace MBUA\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'User_Custom_Fields' ) ) {
	/**
	 * Handle showing the user custom fields.
	 *
	 * @since 1.0.0
	 */
	class User_Custom_Fields {
		/**
		 * This class's instance.
		 *
		 * @since 1.0.0
		 *
		 * @var User_Custom_Fields Singleton instance of the class.
		 */
		private static $instance = null;

		/**
		 * Return the single instance of the class.
		 *
		 * @since 1.0.0
		 *
		 * @return User_Custom_Fields Return instance of the class User_Custom_Fields.
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
			add_action( 'show_user_profile', array( $this, 'display_user_custom_fields' ) );
			add_action( 'edit_user_profile', array( $this, 'display_user_custom_fields' ) );
		}

		/**
		 * Return the user/ author identification meta key added from external site.
		 *
		 * @since 1.0.0
		 *
		 * @return string The meta key to identify user/ author.
		 */
		public static function get_user_identification_meta_key() {
			/**
			 * Filter to modify the user/ author identification meta key.
			 *
			 * @since 1.0.0
			 *
			 * @param string Default is 'mbua_user_source'.
			 */
			$mbua_user_identification_meta_key = apply_filters( 'mbua_user_identification_meta_key', 'mbua_user_source' );

			return $mbua_user_identification_meta_key;
		}

		/**
		 * Return the user/ author identification meta value added from external site.
		 *
		 * @since 1.0.0
		 *
		 * @return string The meta value to identify user/ author.
		 */
		public static function get_user_identification_meta_value() {
			/**
			 * Filter to modify the user/ author identification meta value.
			 *
			 * @since 1.0.0
			 *
			 * @param string Default is 'mbua_user_source'.
			 */
			$mbua_user_identification_meta_value = apply_filters( 'mbua_user_identification_meta_value', 'https://jsonplaceholder.typicode.com/users/' );

			return $mbua_user_identification_meta_value;
		}

		/**
		 * Display the user custom fields on the user profile page.
		 *
		 * @param WP_USER $wp_user The current WP_User object.
		 * @since 1.0.0
		 */
		public function display_user_custom_fields( $wp_user ) {
			?>
			<h3><?php _e( 'Extra Fields Imported Using API', 'mbua-migrate-blogs' ); ?></h3>

			<table class="mbua-user-custom-fields-wrapper form-table">
				<!-- Address Street Field -->
				<tr>
					<th>
						<label for="mbua-address-street-user-cf"><?php _e( 'Address Street', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-address-street-user-cf" id="mbua-address-street-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_address_street' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Address Suite Field -->
				<tr>
					<th>
						<label for="mbua-address-suite-user-cf"><?php _e( 'Address Suite', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-address-suite-user-cf" id="mbua-address-suite-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_address_suite' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Address City Field -->
				<tr>
					<th>
						<label for="mbua-address-city-user-cf"><?php _e( 'Address City', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-address-city-user-cf" id="mbua-address-city-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_address_city' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Address Pincode Field -->
				<tr>
					<th>
						<label for="mbua-address-pincode-user-cf"><?php _e( 'Address Pincode', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-address-pincode-user-cf" id="mbua-address-pincode-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_address_pincode' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Phone Field -->
				<tr>
					<th>
						<label for="mbua-phone-user-cf"><?php _e( 'Phone', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-phone-user-cf" id="mbua-phone-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_phone' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Company Name Field -->
				<tr>
					<th>
						<label for="mbua-company-name-user-cf"><?php _e( 'Company Name', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-company-name-user-cf" id="mbua-company-name-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_company_name' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- Website Field -->
				<tr>
					<th>
						<label for="mbua-website-user-cf"><?php _e( 'Website', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-website-user-cf" id="mbua-website-user-cf" value="<?php echo esc_attr( $wp_user->get( 'mbua_website' ) ); ?>" class="regular-text" />
					</td>
				</tr>
				<!-- User Source/ Migrated From Field -->
				<tr>
					<th>
						<label for="mbua-source-user-cf"><?php _e( 'Migrated From', 'mbua-migrate-blogs' ); ?></label>
					</th>
					<td>
						<input type="text" name="mbua-source-user-cf" id="mbua-source-user-cf" value="<?php echo esc_attr( $wp_user->get( self::get_user_identification_meta_key() ) ); ?>" class="regular-text" disabled />
					</td>
				</tr>
			</table>
			<?php
		}
	}
}
