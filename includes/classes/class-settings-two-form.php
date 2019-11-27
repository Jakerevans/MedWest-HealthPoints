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

if ( ! class_exists( 'MedWesthealthpoints_settings2_Form', false ) ) :

	/**
	 * MedWesthealthpoints_Admin_Menu Class.
	 */
	class MedWesthealthpoints_settings2_Form {


		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings2_form() {
			global $wpdb;

			wp_enqueue_media();

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here you can create Brand-New Activities for your Users to participate in!</p>
						</div>
						<div id="medwest-form-create-reward-wrapper">
							<div>
								<label>Name of Activity</label>
								<input id="medwest-input-activityname" type="text" />
							</div>
							<div>
								<label>Activity Category</label>
								<select id="medwest-input-activitycategory">
									<option default selected disabled>Select An Activity Category...</option>
									<option>Wellness</option>
									<option>Exercise</option>
									<option>Education</option>
									<option>Event</option>
								</select>
							</div>
							<div>
								<label>Points Value</label>
								<input id="medwest-input-activitypointsvalue" type="number" />
							</div>
							<div>
								<label>Supporting Documentation Required?</label>
								<select id="medwest-input-supportingdocsrequired">
									<option>Yes</option>
									<option>No</option>
								</select>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<div style="display: block; margin-left:auto; margin-right:auto;" class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div>
								<button id="medwest-create-activity-backend-button">Create Activity!</button>
							</div>
						</div>';


			echo $string1;
		}
	}
endif;
