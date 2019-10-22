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

			wp_enqueue_media();

			$this->rewardsobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_rewards' );

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here You Can Edit & Delete Your Existing Rewards.</p>
						</div>';

			$reward_html = '';
			foreach ( $this->rewardsobject as $key => $reward ) {
				$reward_html = $reward_html . '
					<div id="medwest-form-create-reward-top-wrapper">
						<div id="medwest-form-create-reward-wrapper">
							<div>
								<label>Name of Reward</label>
								<input id="medwest-input-rewardname" type="text" value="' . $reward->rewardname . '">
							</div>
							<div>
								<label>Reward Point Value</label>
								<input id="medwest-input-rewardpointvalue" type="number" value="' . $reward->rewardpointvalue . '">
							</div>
							<div>
								<label>Reward URL</label>
								<input type="text" id="medwest-input-rewardurl" value="' . $reward->rewardurl . '">
							</div>
							<div>
								<label class="medwest-form-section-fields-label" style="color: black;">Reward Image</label>
								<input class="medwest-form-section-fields-input medwest-form-section-fields-input-text" id="medwest-input-rewardimage" type="text" value="' . $reward->rewardimage . '">
								<button class="medwest-form-section-fields-input medwest-form-section-fields-input-button medwest-form-section-fields-input-file-upload-button" id="medwest-form-button-vetdd214-0" data-dbtype="%s" data-dbname="vetdd214-button">Choose File</button>
							</div>
							<div>
								<label>Reward Description</label>
								<textarea id="medwest-input-rewarddescription">' . $reward->rewarddescription . '</textarea>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<button data-rewardid="' . $reward->ID . '" class="medwest-edit-reward-backend-button" id="medwest-edit-reward-backend-button">Edit Reward</button>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<button data-rewardid="' . $reward->ID . '" class="medwest-delete-reward-backend-button" id="medwest-delete-reward-backend-button">Delete Reward</button>
							</div>
						</div>
					</div>';


			}


			echo $string1 . $reward_html;
		}
	}
endif;
