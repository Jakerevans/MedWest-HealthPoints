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

			$this->activityobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities' );

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here You Can Edit & Delete Your Existing Activities.</p>
						</div>';

			$activity_html = '';
			$activty_supporting_required = '';
			foreach ( $this->activityobject as $key => $activity ) {

				$option_html = '';
				$docs_html = '';
				switch ( $activity->activitycategory ) {
					case 'Wellness':
						$option_html = '<option disabled>Select An Activity Category...</option>
									<option selected>Wellness</option>
									<option>Exercise</option>
									<option>Education</option>
									<option>Event</option>';
						break;
					case 'Exercise':
						$option_html = '<option disabled>Select An Activity Category...</option>
									<option>Wellness</option>
									<option selected>Exercise</option>
									<option>Education</option>
									<option>Event</option>';
						break;
					case 'Education':
						$option_html = '<option disabled>Select An Activity Category...</option>
									<option>Wellness</option>
									<option>Exercise</option>
									<option selected>Education</option>
									<option>Event</option>';
						break;
					case 'Event':
						$option_html = '<option disabled>Select An Activity Category...</option>
									<option>Wellness</option>
									<option>Exercise</option>
									<option>Education</option>
									<option selected>Event</option>';
						break;
					default:
						# code...
						break;
				}

				switch ( $activity->activitysupportingdocsrequired ) {
					case 'Yes':
						$docs_html = '<option selected>Yes</option>
										<option>No</option>';
						break;
					case 'No':
						$docs_html = '<option>Yes</option>
										<option selected>No</option>';
						break;
					default:
						$docs_html = '<option>Yes</option>
										<option>No</option>';
						break;
				}

				$activity_html = $activity_html . '
					<div id="medwest-form-create-reward-top-wrapper">
						<div id="medwest-form-create-reward-wrapper">
							<div id="medwest-form-create-reward-wrapper">
							<div>
								<label>Name of Activity</label>
								<input id="medwest-input-activityname" type="text" value="' . $activity->activityname . '"/>
							</div>
							<div>
								<label>Activity Category</label>
								<select id="medwest-input-activitycategory">
									' . $option_html . '
								</select>
							</div>
							<div>
								<label>Points Value</label>
								<input id="medwest-input-activitypointsvalue" type="number" value="' . $activity->activitypointsvalue . '"/>
							</div>
							<div>
								<label>Supporting Documentation Required?</label>
								<select id="medwest-input-supportingdocsrequired">
									' . $docs_html . '
								</select>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<div style="display: block; margin-left:auto; margin-right:auto;" class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div>
								<button class="medwest-edit-activity-backend-button" data-id="' . $activity->ID . '">Edit Activity</button>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<button data-id="' . $activity->ID . '" class="medwest-delete-activity-backend-button">Delete Activity</button>
							</div>
						</div>
						</div>
					</div>';


			}


			echo $string1 . $activity_html;
		}
	}
endif;
