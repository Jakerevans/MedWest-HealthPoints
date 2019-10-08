<?php
/**
 * MedWesthealthpoints MedWesthealthpoints_Toplevel_Update Class
 *
 * @author   Jake Evans
 * @category admin
 * @package  classes/update
 * @version  1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWesthealthpoints_Toplevel_Update', false ) ) :
	/**
	 * MedWesthealthpoints_Toplevel_Update Class.
	 */
	class MedWesthealthpoints_Toplevel_Update {

		/**
		 * Class Constructor
		 */
		public function __construct() {

			$this->medwesthealthpoints_update_kickoff();

		}


		/**
		 * Outputs the actual HTML for the tab.
		 */
		public function medwesthealthpoints_update_kickoff() {

			if ( ! class_exists( 'MedWesthealthpoints_Toplevel_Update_Actual' ) ) {

				// Load our custom updater if it doesn't already exist.
				require_once( MEDWESTHEALTHPOINTS_UPDATE_DIR . 'class-medwesthealthpoints-update-actual.php' );
			}

			global $wpdb;

			// Checking if table exists.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_settings';
			if ( $test_name === $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {

				// Get license key from plugin options, if it's already been saved. If it has, don't display anything.
				$extension_settings = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_settings' );
				$extension_settings = explode( '---', $extension_settings->repw);

				// Retrieve our license key from the DB.
				$license_key = $extension_settings[0];

				// Setup the updater.
				$edd_updater = new MedWesthealthpoints_Toplevel_Update_Actual( EDD_SL_STORE_URL_MEDWESTHEALTHPOINTS, MEDWESTHEALTHPOINTS_ROOT_DIR . 'medwesthealthpoints.php', array(
					'version' => MEDWESTHEALTHPOINTS_VERSION_NUM,
					'license' => $license_key,
					'item_id' => EDD_SL_ITEM_ID_MEDWESTHEALTHPOINTS,
					'author'  => 'Jake Evans',
					'url'     => home_url(),
					'beta'    => false,
				) );

			}
		}
	}

endif;
