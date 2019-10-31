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
							<p class="medwesthpplugin-tab-intro-para">Here you can create Brand-New Users for HealthPoints!</p>
						</div>
						<div class="medwesthealthpoints-dashboard-join-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-veteran-join-form-wrapper">
							<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
								<div class="medwesthealthpoints-form-section-wrapper">
									<div class="medwesthealthpoints-form-section-fields-wrapper">
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">First Name</label>
											<input id="medwesthealthpoints-form-firstname" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbname="firstname" type="text"  />
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">Last Name</label>
											<input id="medwesthealthpoints-form-lastname" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text" data-dbtype="%s" data-dbname="lastname" type="text"  />
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper-emailconfirmblock">
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">E-Mail</label>
												<input id="medwesthealthpoints-form-email-veteran" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-email" data-dbtype="%email" data-dbname="email" type="text"  />
											</div>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Confirm E-Mail</label>
												<input id="medwesthealthpoints-form-confirmemail-veteran" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-emailconfirm" data-dbtype="%email" data-dbname="confirmemail" type="text"  />
											</div>
											<div class="medwesthealthpoints-confirmemail-block-message-div" data-activated="false"></div>
										</div>
									</div>
									<div class="medwesthealthpoints-form-section-fields-indiv-wrapper-passwordconfirmblock">
										<label class="medwest-form-section-fields-label">Department</label>
										<select id="medwesthealthpoints-form-vetstate" data-required="true" data-ignore="false" class="medwest-form-section-fields-input medwest-form-section-fields-input-select" data-dbtype="%s" data-dbname="vetstate">
											<option value="default" selected default disabled>Select A Department...</option>
											<option>3 East</option><option>4 North</option><option>6 East</option><option>6B</option><option>Administration</option><option>Anesthesia</option><option>Biomedical Engineering</option><option>Business Office</option><option>Cardiopulmonary Services</option><option>Case Management</option><option>Chaplains</option><option>Compliance</option><option>Emergency Department</option><option>Environmental Services</option><option>Finance</option><option>Food Services</option><option>GI Lab</option><option>Health Information Management</option><option>Hospital Education</option><option>Human Resources</option><option>ICT</option><option>ICU</option><option>Imaging Services</option><option>Information Systems</option><option>Laboratory</option><option>Marketing</option><option>Materials Management</option><option>Medical Staff Services</option><option>Nursing Services Office</option><option>Payroll</option><option>Pharmacy</option><option>Physical Therapy</option><option>Physician Relations</option><option>Plan Operations</option><option>Quality Management</option><option>Rehabilitation Services</option><option>Safety</option><option>Security</option><option>Surgical Services</option><option>Women’s Center</option>
										</select>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">Employee Number</label>
											<input id="medwesthealthpoints-form-firstnum" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbnum="firstnum" type="number"  />
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">HealthPoints</label>
											<input id="medwesthealthpoints-form-healthpoints" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbnum="firstnum" type="number"  />
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">Password</label>
											<input id="medwesthealthpoints-form-password-vet" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-password" data-dbtype="%s" data-dbname="password" type="password"  />
										</div>
										<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
											<label class="medwesthealthpoints-form-section-fields-label">Confirm Password</label>
											<input id="medwesthealthpoints-form-confirmpassword-vet" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text medwesthealthpoints-form-section-fields-input-text-passwordconfirm" data-dbtype="%s" data-dbname="confirmpassword" type="password"  />
										</div>
										<div class="medwesthealthpoints-confirmpassword-block-message-div" data-activated="false"></div>
									</div>
								</div>
							</div>
							<div class="medwesthealthpoints-displayentries-response-div-wrapper">
								<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div>
								<button class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-button medwesthealthpoints-form-section-fields-input-button-apply" data-idtosearchthrough="medwesthealthpoints-dashboard-veteran-join-form-wrapper" data-wptablename="medwesthealthpoints_veterans" data-wptableid="" data-wpuserneeded="true">Join HealthPoints!</button>
								<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-dashboard-veteran-join-form-spinner"></div>
								<div class="medwesthealthpoints-displayentries-response-div-actual-container"></div>
							</div>
						</div>';


			echo $string1;
		}
	}
endif;
