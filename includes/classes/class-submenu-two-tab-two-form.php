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
		public function output_settings1_form( $offset, $page_limit ) {
			global $wpdb;

			$this->usersobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users' );

			function comparator( $object1, $object2 ) {
    			return strcmp( $object1->userlastname, $object2->userlastname );
			}

			usort($this->usersobject, 'comparator'); 




			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here You Can Edit & Delete Your Existing Users.</p>
						</div>';

			$users_html = '';
			foreach ( $this->usersobject as $key => $user ) {
				if ( ( $key >= $offset ) && ( $key < ( $offset + $page_limit ) ) ) {
				$users_html = $users_html . '
						<div class="medwesthealthpoints-dashboard-join-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-veteran-join-form-wrapper-' . $key . '">
							<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
								<div class="medwesthealthpoints-form-section-wrapper medwesthealthpoints-form-section-editusers-wrapper">
									<div data-state="closed" class="medwesthealthpoints-user-title-div">
										' . $user->userfirstname . ' ' . $user->userlastname . '
									</div>
									<div id="medwesthealthpoints-edit-user-wrapper-' . $key . '" class="medwesthealthpoints-edit-details-wrapper">
										<div class="medwesthealthpoints-form-section-fields-wrapper">
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">First Name</label>
												<input id="medwesthealthpoints-form-firstname-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbname="firstname" type="text" value="' . $user->userfirstname . '"/>
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Last Name</label>
												<input id="medwesthealthpoints-form-lastname-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%s" data-dbname="lastname" type="text" value="' . $user->userlastname . '"/>
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper-emailconfirmblock">
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">E-Mail</label>
													<input id="medwesthealthpoints-form-email-veteran-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-email" data-dbtype="%email" data-dbname="email" type="text" value="' . $user->useremail . '" />
												</div>
												<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
													<label class="medwesthealthpoints-form-section-fields-label">Confirm E-Mail</label>
													<input id="medwesthealthpoints-form-confirmemail-veteran-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-emailconfirm" data-dbtype="%email" data-dbname="confirmemail" type="text" value="' . $user->useremail . '" />
												</div>
												<div class="medwesthealthpoints-confirmemail-block-message-div" data-activated="false"></div>
											</div>
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper medwesthealthpoints-form-section-fields-indiv-wrapper-passwordconfirmblock">
											<label class="medwest-form-section-fields-label">Department</label>
											<select style="margin-bottom:15px; " id="medwesthealthpoints-form-vetstate-' . $key . '" data-required="true" data-ignore="false" class="medwest-form-section-fields-input medwest-form-section-fields-input-select" data-dbtype="%s" data-dbname="vetstate">
												<option value="default" selected default disabled>Select A Department...</option>
												<option>3 East</option><option>4 North</option><option>6 East</option><option>6B</option><option>Administration</option><option>Anesthesia</option><option>Biomedical Engineering</option><option>Business Office</option><option>Cardiopulmonary Services</option><option>Case Management</option><option>Chaplains</option><option>Compliance</option><option>Emergency Department</option><option>Environmental Services</option><option>Finance</option><option>Food Services</option><option>GI Lab</option><option>Health Information Management</option><option>Hospital Education</option><option>Human Resources</option><option>ICT</option><option>ICU</option><option>Imaging Services</option><option>Information Systems</option><option>Laboratory</option><option>Marketing</option><option>Materials Management</option><option>Medical Staff Services</option><option>Nursing Services Office</option><option>Payroll</option><option>Pharmacy</option><option>Physical Therapy</option><option>Physician Relations</option><option>Plan Operations</option><option>Quality Management</option><option>Rehabilitation Services</option><option>Safety</option><option>Security</option><option>Surgical Services</option><option>Women’s Center</option>
											</select>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Employee Number</label>
												<input id="medwesthealthpoints-form-employeenum-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbnum="firstnum" type="number" value="' . $user->useridnumber . '" />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">HealthPoints</label>
												<input id="medwesthealthpoints-form-healthpoints-' . $key . '" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbnum="firstnum" type="number" value="' . $user->userhealthpoints . '" />
											</div>
										</div>
										<div class="medwesthealthpoints-displayentries-response-div-wrapper" style="margin-top:0px; position: relative; bottom: 60px;">
											<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1-' . $key . '"></div>
											<button id="medwesthealthpoints-edit-user-button-' . $key . '" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-edit">Save User Edits</button>
											<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-delete">Delete User</button>
											<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-dashboard-veteran-join-form-spinner-' . $key . '"></div>
											<div class="medwesthealthpoints-displayentries-response-div-actual-container"></div>
										</div>
									</div>
								</div>
							</div>
						</div>';
					}

				}

				echo $string1 . $users_html;
			}
	}
endif;
