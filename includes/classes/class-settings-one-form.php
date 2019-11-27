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
			$this->activitiessubmittedobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities_submitted' );

		}

		/**
		 * Outputs all HTML elements on the page.
		 */
		public function output_settings1_form() {
			global $wpdb;

			$contact_form_html = '
				<div class="medwesthpplugin-form-section-wrapper">';

			$activities_html = '';
			foreach ( $this->activitiessubmittedobject as $key => $activity ) {

				if ( 'pending' === $activity->activitystatus ) {

					$this->activitiesobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities WHERE activityname = "' . $activity->activityname . '"' );

					// Get associated employee info.
					$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE useridnumber = ' . $activity->activityemployeeid );

					$supportingdoclink  = '';
					$supportingdoctext  = '';
					$supportingdocstyle = '';
					if ( null === $activity->activitysupportingdocs || '' === $activity->activitysupportingdocs ) {
						$supportingdoctext  = 'No Supporting Documentation Provided!';
						$supportingdoclink  = '';
						$supportingdocstyle = 'style="pointer-events:none;"';

					} else {
						$supportingdoctext  = 'Click For Supporting Documentation...';
						$supportingdoclink  = $activity->activitysupportingdocs;
						$supportingdocstyle = '';
					}

					$activities_html = $activities_html . '
					<div class="medwest-pending-activities-top-indiv-wrapper">
						<div style="display:flex;">
							<div class="medwest-pending-activities-left-wrapper">
								<p class="medwest-pending-activities-left-title">Activity Name: ' . $activity->activityname . '</p>
								<p>Activity Category: ' . ucfirst( $activity->activitycategory ) . '</p>
								<p>Performed on: ' . $activity->activitydateperformed . '</p>
							</div>
							<div class="medwest-pending-activities-middle-wrapper">
								<p>Submitter\'s Name: ' . $this->userobject->userfirstname .' ' . $this->userobject->userlastname  . '</p>
								<p>Submitter\'s Employee Number: ' . $this->userobject->useridnumber  . '</p>
								<p>Submitter\'s Email: ' . $this->userobject->useremail  . '</p>
								<p><a ' . $supportingdocstyle . ' target="_blank" href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
							</div>
							<div class="medwest-pending-activities-right-wrapper">
								<div class="medwest-pending-activities-right-button-wrapper">
									<button class="medwest-activity-approve-button" data-userhealthpoints="' . ( $this->userobject->userhealthpoints + $this->activitiesobject->activitypointsvalue ) . '" data-useremployeeid="' . $this->userobject->useridnumber . '" data-activityid="' . $activity->ID . '">Approve Activity</button>
									<button class="medwest-activity-deny-button" data-userhealthpoints="' . ( $this->userobject->userhealthpoints + $this->activitiesobject->activitypointsvalue ) . '" data-useremployeeid="' . $this->userobject->useridnumber . '" data-activityid="' . $activity->ID . '">Deny Activity</button>
								</div>
							</div>
						</div>
						<div class="medwest-activity-deny-wrapper">
							<p>Please choose a reason that the Activity was denied, so that the Employee can correct any errors and try again.</p>
							<select class="medwest-deny-activity-actual-reason">
								<option selected default disabled>Select a Denial Reason...</option>
								<option>Supporting Documentation was not correct</option>
								<option>Employee already submitted this activity</option>
							</select>
							<button disabled data-activityname="' . $this->activitiesobject->activityname  . '" data-wpuserid="' . $this->userobject->userwpuserid  . '" data-useremail="' . $this->userobject->useremail  . '" class="medwest-activity-deny-button-actual" data-userhealthpoints="' . ( $this->userobject->userhealthpoints + $this->activitiesobject->activitypointsvalue ) . '" data-useremployeeid="' . $this->userobject->useridnumber . '" data-activityid="' . $activity->ID . '">Deny Activity</button>
						</div>
						<div class="medwesthealthpoints-spinner"></div>
					</div>';
				}
			}

			$contact_form_html = $contact_form_html . $activities_html;

			$string1 = '
				</div>
				<div id="medwesthpplugin-display-options-container">
					<p class="medwesthpplugin-tab-intro-para">Below you can view all Pending Activities submitted by Employees.</p>
					<div class="medwesthpplugin-form-wrapper">
						' . $contact_form_html . '
					</div>
				</div>';

			echo $string1;
		}
	}
endif;
