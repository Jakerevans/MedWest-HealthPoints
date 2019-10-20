

<?php
/**
 * MedWestHealthPoints_Dashboard_UI Class that dispalys the login form or the user dashboard - class-medwesthealthpoints-dashboard-ui.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes/Classes
 * @version  6.1.5.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWestHealthPoints_Dashboard_UI', false ) ) :

	/**
	 * MedWestHealthPoints_Admin_Menu Class.
	 */
	class MedWestHealthPoints_Dashboard_UI {

		public $userloggedin                         = false;
		public $usertype                             = false;
		public $userobject                           = null;
		public $username                             = false;
		public $loginform_text                       = 'Already a Member? Log in below!';
		public $userapproved                         = false;
		public $currentwpuserid                      = 0;
		public $login_form_html                      = '';
		public $register_buttons_html                = '';
		public $common_dashboard_closing_html_output = '';
		public $loggedin_dashboard_html_output       = '';
		public $common_dashboard_opening_html_output = '';

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {

			// For grabbing an image from media library.
			wp_enqueue_media();

			// See if we have a currently logged-in user.
			$loggedin = is_user_logged_in();

			// If user is logged in...
			if ( $loggedin ) {

				global $wpdb;
				$currentwpuserid  = get_current_user_id();
				echo $currentwpuserid;
				$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE userwpuserid = ' . $currentwpuserid );
				error_log(var_dump(print_r($this->userobject, true)));
				$this->stitch_final_loggedin_default_dashboard_html();
			


			} else {
				

				$this->stitch_final_register_html();



			}

		}

		/**
		 * Outputs the HTML for the login/register forms.
		 */
		public function display_login_form() {
			global $wpdb;

			$args = array(
				'echo'           => false,
				'remember'       => true,
				'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
				'form_id'        => 'medwesthealthpoints-dashboard-login-row-wrapper',
				'id_username'    => 'user_login',
				'id_password'    => 'user_pass',
				'id_remember'    => 'rememberme',
				'id_submit'      => 'wp-submit',
				'label_username' => __( 'Username' ),
				'label_password' => __( 'Password' ),
				'label_remember' => __( 'Remember Me' ),
				'label_log_in'   => __( 'Log In' ),
				'value_username' => '',
				'value_remember' => false
			);

			$this->login_form_html = '<div id="medwesthealthpoints-dashboard-container">
							<div id="medwesthealthpoints-dashboard-login-wrapper">
								<p class="medwesthealthpoints-tab-intro-para">' . $this->loginform_text . '</p>' . wp_login_form( $args ) . '</div></div>';









						

		}



		/**
		 * Outputs the HTML for the register buttons.
		 */
		public function display_register_buttons() {
			global $wpdb;

			$this->register_buttons_html = '
						<div id="medwesthealthpoints-dashboard-register-options-wrapper">
							<div class="medwesthealthpoints-dashboard-register-options-indiv-wrapper">
								<p class="medwesthealthpoints-tab-intro-para">Not a Member?<br/>Join HealthPoints Below!</p>
								<button id="medwesthealthpoints-join-as-vet" >Join HealthPoints<br/>Today!</button>
							</div>
						</div>';
		}

		/**
		 * Outputs the HTML for the Veteran signup form.
		 */
		public function display_default_signup_forms() {

			$this->vet_signup_form_html = '
						<div class="medwesthealthpoints-dashboard-join-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-veteran-join-form-wrapper">
								<div class="medwesthealthpoints-displayentries-indiv-innerwrapper-form-wrapper">
									<div class="medwesthealthpoints-form-section-wrapper">
										<div class="medwesthealthpoints-form-section-title-wrapper">
											<p>Simply fill out the information below to Join HealthPoints!</p>
										</div>
										<div style="display: inline-block;" class="medwesthealthpoints-form-section-fields-wrapper">
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
											<label class="whitetailwarriors-form-section-fields-label">Department</label>
											<select id="medwesthealthpoints-form-vetstate" data-required="true" data-ignore="false" class="whitetailwarriors-form-section-fields-input whitetailwarriors-form-section-fields-input-select" data-dbtype="%s" data-dbname="vetstate">
												<option value="default" selected default disabled>Select A Department...</option>
												<option>AL</option><option>AK</option><option>AS</option><option>AZ</option><option>AR</option><option>CA</option><option>CO</option><option>CT</option><option>DE</option><option>DC</option><option>FM</option><option>FL</option><option>GA</option><option>GU</option><option>HI</option><option>ID</option><option>IL</option><option>IN</option><option>IA</option><option>KS</option><option>KY</option><option>LA</option><option>ME</option><option>MH</option><option>MD</option><option>MA</option><option>MI</option><option>MN</option><option>MS</option><option>MO</option><option>MT</option><option>NE</option><option>NV</option><option>NH</option><option>NJ</option><option>NM</option><option>NY</option><option>NC</option><option>ND</option><option>MP</option><option>OH</option><option>OK</option><option>OR</option><option>PW</option><option>PA</option><option>PR</option><option>RI</option><option>SC</option><option>SD</option><option>TN</option><option>TX</option><option>UT</option><option>VT</option><option>VI</option><option>VA</option><option>WA</option><option>WV</option><option>WI</option><option>WY</option><option>AE</option><option>AA</option><option>AP</option>
											</select>
											<div class="medwesthealthpoints-form-section-fields-indiv-wrapper">
												<label class="medwesthealthpoints-form-section-fields-label">Employee Number</label>
												<input id="medwesthealthpoints-form-firstnum" data-ignore="false" data-required="true" class="medwesthealthpoints-form-section-fields-input medwesthealthpoints-form-section-fields-input-text"  data-dbtype="%s" data-dbnum="firstnum" type="number"  />
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
							</div>
						</div>';

		}

		/**
		 * Builds and outputs the final HTML for individuals to register.
		 */
		public function stitch_final_register_html() {

			$this->display_login_form();
			$this->display_register_buttons();
			$this->display_default_signup_forms();
			echo $this->login_form_html . $this->register_buttons_html . $this->vet_signup_form_html . $this->default_signup_form_html . $this->volunteer_signup_form_html;

		}

		/**
		 * Builds and outputs the final HTML for individuals who are already registered.
		 */
		public function stitch_final_member_html() {

			$this->loginform_text = 'Log in below!';
			$this->display_login_form();

			echo $this->login_form_html;
			
		}

		/**
		 * Builds the common opening HTML for the Dashboards.
		 */
		public function common_dashboard_opening_html() {

			$this->common_dashboard_opening_html_output = '
				<div class="medwesthealthpoints-dashboard-loggedin-form-wrapper medwesthealthpoints-displayentries-indiv-innerwrapper-form" id="medwesthealthpoints-dashboard-loggedin-top-wrapper">';
			
		}

		/**
		 * Builds the common closing HTML for the Dashboards...
		 */
		public function common_dashboard_closing_html() {

			$this->common_dashboard_closing_html_output = '</div>';

		}

		/**
		 * Builds the Logged-in Dashboard HTML for defaults...
		 */
		public function loggedin_dashboard_html() {

			
		}

		/**
		 * Builds and outputs the final Logged-in Dashboard HTML for defaults.
		 */
		public function stitch_final_loggedin_default_dashboard_html() {
			$this->common_dashboard_opening_html();
			$this->common_dashboard_closing_html();
			$this->loggedin_dashboard_html();
			echo $this->common_dashboard_opening_html_output . $this->loggedin_dashboard_html_output . $this->common_dashboard_closing_html_output;
		}

	}
endif;