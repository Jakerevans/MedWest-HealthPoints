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
			usort( $this->usersobject, 'comparator' );

			$dropdown_array = array(
				'3 East',
				'4 North',
				'6 East',
				'6B',
				'Administration',
				'Anesthesia',
				'Biomedical Engineering',
				'Business Office',
				'Cardiopulmonary Services',
				'Case Management',
				'Chaplains',
				'Compliance',
				'Emergency Department',
				'Environmental Services',
				'Finance',
				'Food Services',
				'GI Lab',
				'Health Information Management',
				'Hospital Education',
				'Human Resources',
				'ICT',
				'ICU',
				'Imaging Services',
				'Information Systems',
				'Laboratory',
				'Marketing',
				'Materials Management',
				'Medical Staff Services',
				'Nursing Services Office',
				'Payroll',
				'Pharmacy',
				'Physical Therapy',
				'Physician Relations',
				'Plan Operations',
				'Quality Management',
				'Rehabilitation Services',
				'Safety',
				'Security',
				'Surgical Services',
				'Women’s Center',
			);


			// Set the current WordPress user.
			$currentwpuser = wp_get_current_user();

			$string1 = '<div id="medwesthpplugin-display-options-container">
							<p class="medwesthpplugin-tab-intro-para">Here you can edit & delete your existing users. Simply click on a User\'s name to see their saved info, and click the \'Save User Edits\' button to edit their information. Users are displayed in Alphabetical order by Last Name.</p>
						</div>';

			$users_html = '';
			foreach ( $this->usersobject as $key => $user ) {
				if ( ( $key >= $offset ) && ( $key < ( $offset + $page_limit ) ) ) {

					$department_dropdown = '';
					foreach ( $dropdown_array as $dept_key => $dept_value ) {

						//echo $dept_value;
						$is_selected = '';
						if ( $user->userdepartment === $dept_value ) {
							$is_selected = 'selected';
						}
						$department_dropdown = $department_dropdown . '<option dept_value="' . $dept_value . '"' . $is_selected . '>' . $dept_value . '</option>';
					}

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
												<option disabled>Select A Department...</option>
												' . $department_dropdown . '
											</select>
											<div style="display:none;" class="medwesthealthpoints-form-section-fields-indiv-wrapper">
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
											<button style="display:none;" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-delete">Delete User</button>
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
