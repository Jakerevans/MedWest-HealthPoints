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

			/*
				Below is a default contact form using default class names, ids, and custom data attributes, with associated default styling found in the "BEGIN CSS FOR COMMON FORM FILL" section of the medwesthealthpoints-admin-ui.scss file. The custom data attribute "data-dbname" is supposed to hold the exact name of the corresponding database column in the database, prefixed with a description of the kind of "object" we're working with. For example, if I were creating an App that needed to save Student data, I would probably call that database table 'studentdata' and each column in that database would begin with 'student'. So, I would replace all instances below of data-dbname="contact with data-dbname="student. I would also replace each instance of id="medwesthpplugin-form-contact with id="medwesthpplugin-form-student. If I were creating an app that needed to track customer info, and not students, I would replace all instances below of data-dbname="contact with data-dbname="customer. I would also replace each instance of id="medwesthpplugin-form-contact with id="medwesthpplugin-form-customer.
			*/
			$contact_form_html = '
				<div class="medwesthpplugin-form-section-wrapper">
					<div class="medwesthpplugin-form-section-title-wrapper">
							<p>Contact Info</p>
					</div>
					<div class="medwesthpplugin-form-section-fields-wrapper">
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">First Name</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactfirstname" data-dbname="contactfirstname" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Last Name</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactlastname" data-dbname="contactlastname" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">E-Mail</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactemail" data-dbname="contactemail" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Confirm E-Mail</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactconfirmemail" data-dbname="contactnull" type="text" value="" />
						</div>
					</div>
					<div class="medwesthpplugin-form-section-fields-wrapper">
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Phone</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactphone" data-dbname="contactphone" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Street Address 1</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactstreetaddress1" data-dbname="contactstreetaddress1" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Street Address 2</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactstreetaddress2" data-dbname="contactstreetaddress2" type="text" value="" />
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">City</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactcity" data-dbname="contactcity" type="text" value="" />
						</div>
					</div>
					<div class="medwesthpplugin-form-section-fields-wrapper">
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">State</label>
							<select class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-select" id="medwesthpplugin-form-contactstate" data-dbname="contactstate">
								<option selected default disabled>Select A State...</option>
								<option value="AL">Alabama</option>
								<option value="AK">Alaska</option>
								<option value="AZ">Arizona</option>
								<option value="AR">Arkansas</option>
								<option value="CA">California</option>
								<option value="CO">Colorado</option>
								<option value="CT">Connecticut</option>
								<option value="DE">Delaware</option>
								<option value="DC">District Of Columbia</option>
								<option value="FL">Florida</option>
								<option value="GA">Georgia</option>
								<option value="HI">Hawaii</option>
								<option value="ID">Idaho</option>
								<option value="IL">Illinois</option>
								<option value="IN">Indiana</option>
								<option value="IA">Iowa</option>
								<option value="KS">Kansas</option>
								<option value="KY">Kentucky</option>
								<option value="LA">Louisiana</option>
								<option value="ME">Maine</option>
								<option value="MD">Maryland</option>
								<option value="MA">Massachusetts</option>
								<option value="MI">Michigan</option>
								<option value="MN">Minnesota</option>
								<option value="MS">Mississippi</option>
								<option value="MO">Missouri</option>
								<option value="MT">Montana</option>
								<option value="NE">Nebraska</option>
								<option value="NV">Nevada</option>
								<option value="NH">New Hampshire</option>
								<option value="NJ">New Jersey</option>
								<option value="NM">New Mexico</option>
								<option value="NY">New York</option>
								<option value="NC">North Carolina</option>
								<option value="ND">North Dakota</option>
								<option value="OH">Ohio</option>
								<option value="OK">Oklahoma</option>
								<option value="OR">Oregon</option>
								<option value="PA">Pennsylvania</option>
								<option value="RI">Rhode Island</option>
								<option value="SC">South Carolina</option>
								<option value="SD">South Dakota</option>
								<option value="TN">Tennessee</option>
								<option value="TX">Texas</option>
								<option value="UT">Utah</option>
								<option value="VT">Vermont</option>
								<option value="VA">Virginia</option>
								<option value="WA">Washington</option>
								<option value="WV">West Virginia</option>
								<option value="WI">Wisconsin</option>
								<option value="WY">Wyoming</option>
							</select>
						</div>
						<div class="medwesthpplugin-form-section-fields-indiv-wrapper">
							<label class="medwesthpplugin-form-section-fields-label">Zip</label>
							<input class="medwesthpplugin-form-section-fields-input medwesthpplugin-form-section-fields-input-text" id="medwesthpplugin-form-contactzip" data-dbname="contactzip" type="text" value="" />
						</div>
					</div>



				</div>';

			$string1 = '
				<div id="medwesthpplugin-display-options-container">
					<p class="medwesthpplugin-tab-intro-para">This is some intro text for Settings 1</p>
					<div class="medwesthpplugin-form-wrapper">
						' . $contact_form_html . '

					


					</div>
				</div>';

			echo $string1;
		}
	}
endif;
