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

			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here you can create Brand-New Rewards for your Users.</p>
						</div>
						<div id="medwest-form-create-reward-wrapper">
							<div>
								<label>Name of Reward</label>
								<input id="medwest-input-rewardname" type="text" />
							</div>
							<div>
								<label>Reward Point Value</label>
								<input id="medwest-input-rewardpointvalue" type="number" />
							</div>
							<div>
								<label>Reward URL</label>
								<input type="text" id="medwest-input-rewardurl" />
							</div>
							<div>
								<label class="medwest-form-section-fields-label" style="color: black;">Reward Image</label>
								<input class="medwest-form-section-fields-input medwest-form-section-fields-input-text" id="medwest-input-rewardimage" type="text" value="">
								<button class="medwest-form-section-fields-input medwest-form-section-fields-input-button medwest-form-section-fields-input-file-upload-button" id="medwest-form-button-vetdd214-0" data-dbtype="%s" data-dbname="vetdd214-button">Choose File</button>
							</div>
							<div>
								<label>Reward Description</label>
								<textarea id="medwest-input-rewarddescription" ></textarea>
							</div>
							<div id="medwest-create-reward-backend-button-wrapper">
								<button id="medwest-create-reward-backend-button">Create Reward!</button>
							</div>
						</div>';


			echo $string1;
		}
	}
endif;
