<?php
/**
 * MedWesthealthpoints Book Display Options Form Tab Class - class-medwesthpplugin-book-display-options-form.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWesthealthpoints_Settings1_Form', false ) ) :

	/**
	 * MedWesthealthpoints_Admin_Menu Class.
	 */
	class MedWesthealthpoints_Settings1_Form {


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form() {
			global $wpdb;

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">This is some intro text for The second tab of the 2nd Submenu Page</p>
						</div>';


			echo $string1;
		}
	}
endif;
