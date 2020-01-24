

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
				$this->currentwpuserid  = get_current_user_id();
				$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE userwpuserid = ' . $this->currentwpuserid );
				
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

			global $wpdb;

			// Update the last logged in value.
			$lastloggedin = $this->userobject->userlastlogin;
			$data         = array(
				'userlastlogin' => date( 'm/d/Y' ),
			);
			$format       = array( '%s' );
			$where        = array( 'userwpuserid' => $this->currentwpuserid );
			$where_format = array( '%s' );
			$wpdb->update( $wpdb->prefix . 'medwesthealthpoints_users', $data, $where, $format, $where_format );

			// Get all available Rewards, determine eligibility, also build HTML for the Popup.
			$this->rewardsobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_rewards' );
			$eligible            = 'Not Quite Yet...';
			$popup_html          = '<div class="medwest-popup-rewards-schedule"><p>* Redemptions will be approved Thursday of each week</p><p>** Rewards will be available for pick up in Human Resources the following Tuesday</p></div>';
			$disabled            = '';
			foreach ( $this->rewardsobject as $key => $reward ) {




				if ( $reward->rewardpointvalue <= $this->userobject->userhealthpoints ) {
					$eligible = 'Yes! Click to Redeem!';
					$disabled = '';
					$leftwith = $this->userobject->userhealthpoints - $reward->rewardpointvalue;
				} else {
					$disabled = 'style="pointer-events:none!important; opacity: 0.5!important;"';
					$leftwith = '';
				}


				$popup_html = $popup_html . '
				<div class="medwest-popup-indiv-rewards-wrapper">
					<div class="medwest-popup-firstrow">
						<p class="medwest-popup-title"><a href="' . $reward->rewardurl . '">' . $reward->rewardname . '</a></p>
					</div>
					<div class="medwest-popup-secondrow">
						<div class="medwest-popup-reward-image-row">
							<img src="' . $reward->rewardimage . '" />
						</div>
						<div class="medwest-popup-reward-description-row">
							<p>' . $reward->rewarddescription . '</p>
						</div>
						<div class="medwest-popup-reward-redeem-row">
							<div>' . $reward->rewardpointvalue . ' HealthPoints</div>
							<button  ' . $disabled . ' class="medwest-popup-reward-redeem-actual">Click to Redeem!</button>
						</div>
					</div>
					<div class="medwest-hidden-request-reward-verify-wrapper">
						<p>Are you sure? Once you request this reward, there\'s no going back... you\'ll be left with ' . ( $this->userobject->userhealthpoints - $reward->rewardpointvalue ) . ' HealthPoints afterwards, and will be contacted by an Admin with further instructions on how to receive your Reward.</p>
						<button class="medwest-popup-reward-redeem-actual-verified" data-rewardsrequestdate="' . date("m/d/Y") . '" data-rewardsrequestrewardsname="' . $reward->rewardname . '" data-rewardrequestrewardsid="' . $reward->ID . '" data-rewardrequestwpuserid="' . $this->userobject->userwpuserid . '" data-rewardrequestfirstlastname="' . $this->userobject->userfirstname . ' ' . $this->userobject->userlastname . '" data-rewardrequestemployeeid=' . $this->userobject->useridnumber . ' data-leftwith="' . $leftwith . '">I\'m Sure!</button>
						<div class="medwesthealthpoints-spinner"></div>
					</div>
				</div>';

				

			}


			// Get all Activities
			$this->activitiesobject      = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities' );
			$category_dropdown_wellness  = '<select data-category="wellness" class="medwest-activity-dropdown-actual"><option default>Choose a Wellness Activity...</option>';
			$category_dropdown_exercise  = '<select data-category="exercise" class="medwest-activity-dropdown-actual"><option default>Choose an Exercise Activity...</option>';
			$category_dropdown_education = '<select data-category="education" class="medwest-activity-dropdown-actual"><option default>Choose an Education Activity...</option>';
			$category_dropdown_event     = '<select data-category="event" class="medwest-activity-dropdown-actual"><option default>Choose an Event Activity...</option>';

			// Get all submitted Activities
			$this->activitiessubmittedobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities_submitted WHERE activitywpuserid = ' . $this->currentwpuserid );
			$category_past_wellness          = '';
			$category_past_exercise          = '';
			$category_past_education         = '';
			$category_past_event             = '';

			// Get any Denied Activities the User may have.
			$this->deniedactivitiesobject = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_notifications WHERE notificationuseridnumber = ' . $this->userobject->useridnumber );

			// Now build the Denied Activities HTML
			$deniedactivityhtml = '';
			foreach ( $this->deniedactivitiesobject as $deniedkey => $deniedvalue ) {
				$deniedactivityhtml = $deniedactivityhtml . '
					<div class="medwest-denied-activity-div">
						<div id="medwest-denied-activity-div-text-message">
							<p>Whoops! Looks like your "' . $deniedvalue->notificationactivityname  . '" Activity Submission was denied!</p>
							<p>Please consider correcting the error below and re-submitting your Activity. Sorry for the hassle!</p>
							<p style="margin-top: 10px; margin-bottom:10px;"><strong>Reason for Denial:</strong> ' . $deniedvalue->notificationtext . '</p>
						</div>
						<button data-id="' . $deniedvalue->ID . '" data-activityname="' . $deniedvalue->notificationactivityname  . '" data-wpuserid="' . $this->userobject->userwpuserid  . '" data-useremail="' . $this->userobject->useremail  . '" data-useremployeeid="' . $this->userobject->useridnumber . '" class="medwest-denied-activity-div-text-button">I Got It!</button>
					</div>';
			}


			foreach ( $this->activitiessubmittedobject as $key => $activity ) {

				// Make sure we lowercase the Category names...
				$activity->activitycategory = strtolower( $activity->activitycategory );

				$supportingdoclink  = '';
				$supportingdoctext  = '';
				$supportingdocstyle = '';
				if ( null === $activity->activitysupportingdocs || '' === $activity->activitysupportingdocs ) {
					$supportingdoctext = 'No Supporting Documentation Provided!';
					$supportingdoclink = '';
					$supportingdocstyle = 'style="pointer-events:none;"';

				} else if ( 'Admin Assigned - No Supporting Docs' === $activity->activitysupportingdocs ) {
					$supportingdoctext = 'Admin Assigned - No Supporting Docs';
					$supportingdoclink = $activity->activitysupportingdocs;
					$supportingdocstyle = 'style="pointer-events:none;"';
				} else {
					$supportingdoctext = 'Click For Supporting Documentation...';
					$supportingdoclink = $activity->activitysupportingdocs;
					$supportingdocstyle = '';
				}


				// Build out the Dropdowns and the individual saved Activities entries.
				switch ( $activity->activitycategory ) {
					case 'wellness':
						$category_past_wellness = $category_past_wellness . '
						<div class="medwest-saved-act-indiv-wrapper">
							<p class="medwest-saved-act-title">' . $activity->activityname . '</p>
							<div>
								<p>Date Performed: ' . $activity->activitydateperformed . '</p>
								<p>Activity Status: ' . ucfirst( $activity->activitystatus ) . '</p>
								<p><a ' . $supportingdocstyle . ' href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
								<p></p>
							</div>
						</div>';
						break;
					case 'education':
						$category_past_education = $category_past_education . '
						<div class="medwest-saved-act-indiv-wrapper">
							<p class="medwest-saved-act-title">' . $activity->activityname . '</p>
							<div>
								<p>Date Performed: ' . $activity->activitydateperformed . '</p>
								<p>Activity Status: ' . $activity->activitystatus . '</p>
								<p><a ' . $supportingdocstyle . ' href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
								<p></p>
							</div>
						</div>';
						break;
					case 'exercise':
						$category_past_exercise = $category_past_exercise . '
						<div class="medwest-saved-act-indiv-wrapper">
							<p class="medwest-saved-act-title">' . $activity->activityname . '</p>
							<div>
								<p>Date Performed: ' . $activity->activitydateperformed . '</p>
								<p>Activity Status: ' . $activity->activitystatus . '</p>
								<p><a ' . $supportingdocstyle . ' href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
								<p></p>
							</div>
						</div>';
						break;
					case 'event':
						$category_past_event = $category_past_event . '
						<div class="medwest-saved-act-indiv-wrapper">
							<p class="medwest-saved-act-title">' . $activity->activityname . '</p>
							<div>
								<p>Date Performed: ' . $activity->activitydateperformed . '</p>
								<p>Activity Status: ' . $activity->activitystatus . '</p>
								<p><a ' . $supportingdocstyle . ' href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
								<p></p>
							</div>
						</div>';
						break;
					default:
						# code...
						break;
				}
			}


			foreach ( $this->activitiesobject as $key => $activity ) {
				// Build out the Dropdowns and the individual saved Activities entries.
				switch ( $activity->activitycategory ) {
					case 'Wellness':
						$category_dropdown_wellness = $category_dropdown_wellness . '<option data-requireddocs="' . $activity->activitysupportingdocsrequired . '" value="' . $activity->activityname . '">' . $activity->activityname . '</option>';
						break;
					case 'Education':
						$category_dropdown_education = $category_dropdown_education . '<option data-requireddocs="' . $activity->activitysupportingdocsrequired . '" value="' . $activity->activityname . '">' . $activity->activityname . '</option>';
						break;
					case 'Exercise':
						$category_dropdown_exercise = $category_dropdown_exercise . '<option data-requireddocs="' . $activity->activitysupportingdocsrequired . '" value="' . $activity->activityname . '">' . $activity->activityname . '</option>';
						break;
					case 'Event':
						$category_dropdown_event = $category_dropdown_event . '<option data-requireddocs="' . $activity->activitysupportingdocsrequired . '" value="' . $activity->activityname . '">' . $activity->activityname . '</option>';
						break;
					default:
						# code...
						break;
				}
			}

			$category_dropdown_wellness  = $category_dropdown_wellness . '</select>';
			$category_dropdown_exercise  = $category_dropdown_exercise . '</select>';
			$category_dropdown_education = $category_dropdown_education . '</select>';
			$category_dropdown_event     = $category_dropdown_event . '</select>';

			$catquery = new WP_Query( 'cat=2&posts_per_page=5' ); 
 $post = '';
while($catquery->have_posts()) : $catquery->the_post();
 
$post = get_the_title();
endwhile;
    wp_reset_postdata();

			$this->loggedin_dashboard_html_output = '
				<div id="medwest-notification-div">
					' . $deniedactivityhtml . '
				</div>
				<div id="medwest-rev-and-message-container">
					
'.

do_shortcode('[vc_row][vc_column width="2/3"][rev_slider_vc alias="testalias"][/vc_column][vc_column width="1/3"][vc_raw_html]JTNDZGl2JTIwaWQlM0QlMjJtZWR3ZXN0LXJldi1hbmQtbWVzc2FnZS1jb250YWluZXItaGVhbHRocG9pbnRzJTIyJTNFJTBBJTIwJTIwJTNDZGl2JTIwaWQlM0QlMjJtZWR3ZXN0LXJldi1hbmQtbWVzc2FnZS1sZWZ0JTIyJTNFJTBBJTNDaW1nJTIwc3JjJTNEJTIyaHR0cHMlM0ElMkYlMkZ3ZWxsbmVzcy5tZWRpY2Fsd2VzdGhvc3BpdGFsLm9yZyUyRndwLWNvbnRlbnQlMkZ1cGxvYWRzJTJGMjAyMCUyRjAxJTJGd2VsbG5lc3MtbG9nby5wbmclMjIlMjAlMkYlM0UlMEElM0MlMkZkaXYlM0UlMEElM0NkaXYlMjBpZCUzRCUyMm1lZHdlc3QtcmV2LWFuZC1tZXNzYWdlLXJpZ2h0JTIyJTNFJTBBJTIwJTIwJTNDcCUyMGlkJTNEJTIybWVkd2VzdC1yZXYtYW5kLW1lc3NhZ2UtcDElMjIlM0VZT1UlMjBIQVZFJTNDJTJGcCUzRSUwQSUyMCUyMCUzQ3AlMjBpZCUzRCUyMm1lZHdlc3QtcmV2LWFuZC1tZXNzYWdlLXAyJTIyJTNFJTNDJTJGcCUzRSUwQSUyMCUyMCUzQ3AlMjBpZCUzRCUyMm1lZHdlc3QtcmV2LWFuZC1tZXNzYWdlLXAzJTIyJTNFSEVBTFRIUE9JTlRTJTNDJTJGcCUzRSUwQSUyMCUyMCUzQ3AlMjBzdHlsZSUzRCUyMmZvbnQtc3R5bGUlM0FpdGFsaWMlM0IlMjIlMjBjbGFzcyUzRCUyMm1lZHdlc3QtbG9nZ2VkaW4taW5kaXYtd3JhcHBlci1hY3R1YWwtZGF0YSUyMiUyMGlkJTNEJTIybWVkd2VzdC1sb2dnZWRpbi1mcm9udGVuZC1jb2xvcmJveC10cmlnZ2VyJTIyJTNFQ2xpY2slMjBoZXJlJTIwdG8lMjByZWRlZW0lMjBhJTIwcmV3YXJkJTIxJTNDJTJGcCUzRSUwQSUzQyUyRmRpdiUzRSUwQSUwQSUwQSUzQyUyRmRpdiUzRQ==[/vc_raw_html][vc_basic_grid post_type="post" max_items="1" element_width="12" grid_id="vc_gid:1578925866525-dc399e3c-7e36-1"][/vc_column][/vc_row]').'
				</div>
				<!--
				<div id="medwest-loggedin-title-div">
					<p>Welcome ' . $this->userobject->userfirstname . '!<br/><a style="font-variant: all-petite-caps;" href="' . wp_logout_url( get_permalink() ) . '">Logout</a><br/>
					<a data-wpuserid="' . $this->userobject->userwpuserid . '" data-usertableid="' . $this->userobject->ID . '" data-saveedits="false" class="medwest-frontend-edit-profile" style="font-variant: all-petite-caps;" >Edit Profile</a>
					</p>
				</div>
				<div id="medwest-loggedin-profile-wrapper">
					<div class="medwest-loggedin-indiv-profile-piece-wrapper">
						<div class="medwest-loggedin-indiv-wrapper-actual">
							<div class="medwest-loggedin-indiv-wrapper-actual-title">Member Since:</div>
							<div class="medwest-loggedin-indiv-wrapper-actual-data">' . $this->userobject->userjoindate . '</div>
						</div>
					</div>
					<div class="medwest-loggedin-indiv-profile-piece-wrapper">
						<div class="medwest-loggedin-indiv-wrapper-actual">
							<div class="medwest-loggedin-indiv-wrapper-actual-title">Last Login:</div>
							<div class="medwest-loggedin-indiv-wrapper-actual-data">' . $lastloggedin . '</div>
						</div>
					</div>
					<div class="medwest-loggedin-indiv-profile-piece-wrapper">
						<div class="medwest-loggedin-indiv-wrapper-actual">
							<div class="medwest-loggedin-indiv-wrapper-actual-title">HealthPoints:</div>
							<div class="medwest-loggedin-indiv-wrapper-actual-data">' . $this->userobject->userhealthpoints . '</div>
						</div>
					</div>
					<div class="medwest-loggedin-indiv-profile-piece-wrapper">
						<div class="medwest-loggedin-indiv-wrapper-actual">
							<div class="medwest-loggedin-indiv-wrapper-actual-title">User Email:</div>
							<input disabled type="text" class="medwest-loggedin-indiv-wrapper-actual-data" id="medwest-loggedin-indiv-wrapper-actual-data-email-edit" value="' . $this->userobject->useremail . '"/>
						</div>
					</div>
					<div class="medwest-loggedin-indiv-profile-piece-wrapper">
						<div class="medwest-loggedin-indiv-wrapper-actual" id="medwest-loggedin-frontend-colorbox-trigger">
							<div class="medwest-loggedin-indiv-wrapper-actual-title">Reward(s) Available?</div>
							<div class="medwest-loggedin-indiv-wrapper-actual-data">' . $eligible . '</div>
						</div>
					</div>
				</div>
				<div id="medwest-loggedin-title-div">
					<p>Activities</p>
				</div>
				-->
				<div class="medwest-record-view-rows-wrapper">
					<div class="medwest-record-view-rows">
						<div style="background-color:#306c4b;" class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="record-exercise">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button"><div class="medwest-loggedin-record-img"><img src="' . MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'Dumbbell-01.png"/></div><div class="medwest-loggedin-record-text">RECORD AN<br/><span style="font-weight:bold;">EXERCISE</span> ACTIVITY</div></div>
							</div>
						</div>
						<div style="background-color:#609a3c;" class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="record-wellness">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button"><div class="medwest-loggedin-record-img"><img src="' . MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'Heart-01.png"/></div><div class="medwest-loggedin-record-text">RECORD A<br/><span style="font-weight:bold;">WELLNESS</span> ACTIVITY</div></div>
							</div>
						</div>
						<div style="background-color:#6ab9b1;" class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="record-education">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button"><div class="medwest-loggedin-record-img"><img src="' . MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'Pencil-01.png"/></div><div class="medwest-loggedin-record-text">RECORD AN<br/><span style="font-weight:bold;">EDUCATION</span> ACTIVITY</div></div>
							</div>
						</div>
						<div style="background-color:#316861;" class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="record-event">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button"><div class="medwest-loggedin-record-img"><img src="' . MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'Location-01.png"/></div><div class="medwest-loggedin-record-text">RECORD AN<br/><span style="font-weight:bold;">EVENT</span> ACTIVITY</div></div>
							</div>
						</div>
					</div>
					<!--
					<div class="medwest-record-view-rows">
						<div class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="view-exercise">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button">View Exercise Activity</div>
							</div>
						</div>
						<div class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="view-wellness">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button">View Wellness Activity</div>
							</div>
						</div>
						<div class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="view-education">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button">View Education Activity</div>
							</div>
						</div>
						<div class="medwest-loggedin-indiv-profile-piece-wrapper-button" data-category="view-event">
							<div class="medwest-loggedin-indiv-wrapper-actual-button">
								<div class="medwest-loggedin-indiv-wrapper-actual-data-button">View Event Activity</div>
							</div>
						</div>
					</div>
					-->
					<div id="medwest-hidden-rewards-html-popup" style="display: none;">' . $popup_html . '</div>
					<div class="medwest-record-view-rows-actual">
						<div style="display: none;">
							<div id="medwest-dropdown-wellness">' . $category_dropdown_wellness . '</div>
							<div id="medwest-dropdown-exercise">' . $category_dropdown_exercise . '</div>
							<div id="medwest-dropdown-education">' . $category_dropdown_education . '</div>
							<div id="medwest-dropdown-event">' . $category_dropdown_event . '</div>
						</div>
						<div class="medwest-saved-activities-top-wrapper" id="medwest-saved-activities-top-wrapper-wellness" data-activity="wellness">
							<div id="medwest-loggedin-title-div">
								<p id="medwest-dynamic-record-view-activity-title">View Your Saved Wellness Activities Below</p>
							</div>
							<div class="medwest-saved-activities-all-wrapper">
							' . $category_past_wellness . '
							</div>
						</div>

						<div class="medwest-saved-activities-top-wrapper" id="medwest-saved-activities-top-wrapper-exercise" data-activity="exercise">
							<div id="medwest-loggedin-title-div">
								<p id="medwest-dynamic-record-view-activity-title">View Your Saved Exercise Activities Below</p>
							</div>
							<div class="medwest-saved-activities-all-wrapper">
							' . $category_past_exercise . '
							</div>
						</div>

						<div class="medwest-saved-activities-top-wrapper" id="medwest-saved-activities-top-wrapper-education" data-activity="education">
							<div id="medwest-loggedin-title-div">
								<p id="medwest-dynamic-record-view-activity-title">View Your Saved Education Activities Below</p>
							</div>
							<div class="medwest-saved-activities-all-wrapper">
							' . $category_past_education . '
							</div>
						</div>
						<div class="medwest-saved-activities-top-wrapper" id="medwest-saved-activities-top-wrapper-event" data-activity="event">
							<div id="medwest-loggedin-title-div">
								<p id="medwest-dynamic-record-view-activity-title">View Your Saved Event Activities Below</p>
							</div>
							<div class="medwest-saved-activities-all-wrapper">
							' . $category_past_event . '
							</div>
						</div>
						<div id="medwest-record-view-rows-actual-form-wrapper">
							<div id="medwest-loggedin-title-div">
								<p id="medwest-dynamic-record-view-activity-title">Record Your Activity</p>
							</div>
							<div id="medwest-record-view-rows-actual-fields-wrapper">
								<div id="medwest-dynamic-record-view-activity-dropdown">' . $category_dropdown_wellness . '</div>
								<div class="medwest-fields-organizer">
									<label>Date Activity Was Performed:</label>
									<input id="medwest-date-performed-input" type="date"/>
								</div>
								<div class="medwest-fields-organizer">
									<label class="medwest-form-section-fields-label" style="color: black;">Supporting Documentation:</label>
									<input data-ignore="false" data-required="' . $this->activitiesobject->activitysupportingdocsrequired . '" data-dbtype="%s" data-dbname="vetdd214" class="medwest-form-section-fields-input medwest-form-section-fields-input-text" id="medwest-form-vetdd214-0" type="text" value="' . $this->userveteranobject->vetdd214 . '">
									<button class="medwest-form-section-fields-input medwest-form-section-fields-input-button medwest-form-section-fields-input-file-upload-button" id="medwest-form-button-vetdd214-0" data-dbtype="%s" data-dbname="vetdd214-button">Choose File</button>
								</div>
							</div>
							<div class="medwesthealthpoints-spinner" id="medwesthealthpoints-spinner-1"></div>
							<button data-activityemployeeid="' . $this->userobject->useridnumber . '" data-wpuserid="' . $this->currentwpuserid . '" id="medwest-submit-activity-submissions-button">Submit Activity!</button>
						</div>
					</div>
				</div>

			';


			
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