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

			global $wpdb;

			// Get all submitted Activities
			$this->rewardssubmittedobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_rewardrequests' );

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form() {
			global $wpdb;

			/*
				Below is a default contact form using default class names, ids, and custom data attributes, with associated default styling found in the "BEGIN CSS FOR COMMON FORM FILL" section of the medwesthealthpoints-admin-ui.scss file. The custom data attribute "data-dbname" is supposed to hold the exact name of the corresponding database column in the database, prefixed with a description of the kind of "object" we're working with. For example, if I were creating an App that needed to save Student data, I would probably call that database table 'studentdata' and each column in that database would begin with 'student'. So, I would replace all instances below of data-dbname="contact with data-dbname="student. I would also replace each instance of id="medwesthpplugin-form-contact with id="medwesthpplugin-form-student. If I were creating an app that needed to track customer info, and not students, I would replace all instances below of data-dbname="contact with data-dbname="customer. I would also replace each instance of id="medwesthpplugin-form-contact with id="medwesthpplugin-form-customer.
			*/
			$contact_form_html = '
				<div class="medwesthpplugin-form-section-wrapper">';

			$activities_html = '';
			foreach ( $this->rewardssubmittedobject as $key => $reward ) {

				if ( 'pending' === $reward->rewardrequeststatus ) {

					$this->activitiesobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_rewards WHERE ID = "' . $reward->rewardrequestrewardsid . '"' );

					// Get associated employee info
					$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE useridnumber = ' . $reward->rewardrequestemployeeid );

					$activities_html = $activities_html . '
					<div class="medwest-pending-activities-top-indiv-wrapper">
						<div class="medwest-pending-activities-left-wrapper">
							<p class="medwest-pending-activities-left-title">Reward Name: ' . $reward->rewardrequestrewardsname . '</p>
							<p>Requested on: ' . $reward->rewardrequestdate . '</p>
						</div>
						<div class="medwest-pending-activities-middle-wrapper">
							<p>Requester\'s Name: ' . $this->userobject->userfirstname .' ' . $this->userobject->userlastname  . '</p>
							<p>Requester\'s Employee Number: ' . $this->userobject->useridnumber  . '</p>
							<p>Requester\'s Email: ' . $this->userobject->useremail  . '</p>
						</div>
						<div class="medwest-pending-activities-right-wrapper">
							<div class="medwest-pending-activities-right-button-wrapper">
								<button class="medwest-reward-approve-button" data-useremail="' . $this->userobject->useremail . '" data-userhealthpoints="' . $this->userobject->userhealthpoints . '" data-useremployeeid="' . $this->userobject->useridnumber . '" data-rewardrequestid="' . $reward->ID . '">Approve Reward</button>
								<button class="medwest-reward-deny-button" data-userhealthpoints="' . ( $this->userobject->userhealthpoints + $this->activitiesobject->rewardpointvalue ) . '" data-useremployeeid="' . $this->userobject->useridnumber . '" data-rewardrequestid="' . $reward->ID . '">Deny Reward</button>
							</div>
						</div>
					</div>';
				}
			}

			$contact_form_html = $contact_form_html . $activities_html;

			$string1 = '
				</div>
				<div id="medwesthpplugin-display-options-container">
					<p class="medwesthpplugin-tab-intro-para">Below you can view all Pending Reward Requests submitted by Employees.</p>
					<div class="medwesthpplugin-form-wrapper">
						' . $contact_form_html . '

					


					</div>
				</div>';

			echo $string1;
		}
	}
endif;
