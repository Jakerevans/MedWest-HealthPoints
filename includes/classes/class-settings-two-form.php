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

			// Get all current WordPress Users
			$all_users = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users' );
			

			function comparator( $object1, $object2 ) {
				return strcmp( $object1->userlastname, $object2->userlastname );
			}
			usort( $all_users, 'comparator' );

			// Now build out the checkbox html.
			$checkbox_html = '';
			foreach ( $all_users as $key => $value ) {
				$checkbox_html = $checkbox_html . '<div><input data-userhealthpoints="' . $value->userhealthpoints . '" data-wpuserid="' . $value->userwpuserid . '" data-employeeid="' . $value->useridnumber . '" class="medwest-addusertoactivity-checkbox-actual" type="checkbox" value="' . $value->useridnumber .' "/><label>' . $value->userfirstname .' ' . $value->userlastname . '</label></div>';
			}

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
							<div>
								<label>Assign Users To This Activity?</label>
								<select id="medwest-input-adduserstoactivity">
									<option>Choose An Option...</option>
									<option>Yes</option>
									<option>No</option>
								</select>
							</div>
							<div class="medwest-adduserstoactivity-checkbox-holder">
								<div style="display:block; margin-left:auto;margin-right:auto;">
									<button id="medwest-create-activity-checkall-button">Check All</button>
									<button id="medwest-create-activity-uncheckall-button">Uncheck All</button>
								</div>
								' . $checkbox_html . '
								<p style="max-width: 600px; margin-left:auto; margin-right:auto;">Two things will happen when you click the "Create Activity!" Button below - the Activity will be created, and each User whose checkbox is checked above will have this Activity added to their account. Their HealthPoints will be increased by the amount specificed above as well... so make sure everything about this Activity is correct before proceeding! </p>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<div id="medwest-bulk-add-activity-to-users-wrapper">
									<p id="medwest-bulk-add-activity-to-users-estimate-wrapper"></p>
									<p id="medwest-bulk-add-activity-to-users-progress-wrapper"></p>
								</div>
								<div style="display: block; margin-left:auto; margin-right:auto;" class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div>
								<button id="medwest-create-activity-backend-button">Create Activity!</button>
							</div>
						</div>';


			echo $string1;
		}
	}
endif;
