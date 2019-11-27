<?php
/**
 * Class MedWestHealthPoints_Ajax_Functions - class-medwesthpplugin-ajax-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWestHealthPoints_Ajax_Functions', false ) ) :
	/**
	 * MedWestHealthPoints_Ajax_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class MedWestHealthPoints_Ajax_Functions {

		/**
		 * Class Constructor - Simply calls the Translations
		 */
		public function __construct() {


		}

		/**
		 * Callback function for the Edit Book pagination.
		 */
		public function medwesthealthpoints_edit_book_pagination_action_callback() {
			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_edit_book_pagination_action_callback', 'security' );

			if ( isset( $_POST['currentOffset'] ) ) {
				$current_offset = filter_var( wp_unslash( $_POST['currentOffset'] ), FILTER_SANITIZE_NUMBER_INT );
			}


			require_once MEDWESTHEALTHPOINTS_CLASS_DIR . 'class-submenu-two-tab-two-form.php';
			$form     = new MedWesthealthpoints_Settings1_Form();
			echo $form->output_settings1_form( $current_offset, 50 );
			//echo $form->output_edit_book_form( $library, $current_offset ) . '_Separator_' . $library;
			wp_die();
		}


		public function medwesthealthpoints_register_new_user_action_callback() {
			error_log('fdsfdsa');

			global $wpdb;
			//check_ajax_referer( 'medwesthealthpoints_register_new_user_action', 'security' );

			$userfirstname    = '';
			$userlastname     = '';
			$useremail        = '';
			$userpassword     = '';
			$userdepartment   = '';
			$useridnumber     = '';
			$userhealthpoints = '';

			if ( isset( $_POST['userfirstname'] ) ) {
				$userfirstname = filter_var( wp_unslash( $_POST['userfirstname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userlastname'] ) ) {
				$userlastname = filter_var( wp_unslash( $_POST['userlastname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useremail'] ) ) {
				$useremail = filter_var( wp_unslash( $_POST['useremail'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userpassword'] ) ) {
				$userpassword = filter_var( wp_unslash( $_POST['userpassword'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userdepartment'] ) ) {
				$userdepartment = filter_var( wp_unslash( $_POST['userdepartment'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userhealthpoints'] ) ) {
				$userhealthpoints = filter_var( wp_unslash( $_POST['userhealthpoints'] ), FILTER_SANITIZE_NUMBER_INT );
			} else {
				$userhealthpoints = 0;
			}


			// Let's make checks for WordPress user/e-mail already being taken.
			$user_id       = '';
			$usernamecheck = username_exists( $useremail );
			if ( $usernamecheck ) {
				$error = 'Username Exists';
				wp_die( $error );
			}

			if ( email_exists( $useremail ) ) {
				$error = 'E-Mail Exists';
				wp_die( $error );
			}

			if ( ! $usernamecheck && false === email_exists( $useremail ) ) {
				$user_id = wp_create_user( $useremail, $userpassword, $useremail );
				if ( is_wp_error( $user_id ) ) {
					$user_id = 'Unknown error creating WordPress User';
					wp_die( $user_id );
				} else {

					// Now add the user to the custom table.
					$user_table_array = array(
						'userfirstname'    => $userfirstname,
						'userlastname'     => $userlastname,
						'userjoindate'     => date("m/d/Y"),
						'userwpuserid'     => $user_id,
						'userdepartment'   => $userdepartment,
						'useridnumber'     => $useridnumber,
						'userhealthpoints' => $userhealthpoints,
						'userlastlogin'    => date("m/d/Y"),
						'useremail'        => $useremail,
					);

					$user_table_dbtype_array = array(
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%d',
						'%s',
						'%s',
						'%d',
					);

					$users_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_users', $user_table_array, $user_table_dbtype_array );
					$user_id            = $wpdb->insert_id;
					wp_die( $user_id . '--$user_id--' . $useremail );
				}
			}

		}

		public function medwesthealthpoints_edit_existing_user_action_callback() {
			error_log('fdsfdsa');

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_edit_existing_user_action_callback', 'security' );

			$userfirstname    = '';
			$userlastname     = '';
			$useremail        = '';
			$userpassword     = '';
			$userdepartment   = '';
			$useridnumber     = '';
			$userhealthpoints = '';

			if ( isset( $_POST['userfirstname'] ) ) {
				$userfirstname = filter_var( wp_unslash( $_POST['userfirstname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userlastname'] ) ) {
				$userlastname = filter_var( wp_unslash( $_POST['userlastname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useremail'] ) ) {
				$useremail = filter_var( wp_unslash( $_POST['useremail'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userdepartment'] ) ) {
				$userdepartment = filter_var( wp_unslash( $_POST['userdepartment'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userhealthpoints'] ) ) {
				$userhealthpoints = filter_var( wp_unslash( $_POST['userhealthpoints'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$data = array(
				'userfirstname'    => $userfirstname,
				'userlastname'     => $userlastname,
				'userdepartment'   => $userdepartment,
				'useridnumber'     => $useridnumber,
				'userhealthpoints' => $userhealthpoints,
				'useremail'        => $useremail,
			);

			$format = array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
			);

			$where        = array( 'useridnumber' => $useridnumber );
			$where_format = array( '%s' );
			$result = $wpdb->update( $wpdb->prefix . 'medwesthealthpoints_users', $data, $where, $format, $where_format );
			wp_die( $result );

		}

		public function medwesthealthpoints_view_user_activity_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_view_user_activity_action_callback', 'security' );

			$activityemployeeid = '';

			if ( isset( $_POST['activityemployeeid'] ) ) {
				$activityemployeeid = filter_var( wp_unslash( $_POST['activityemployeeid'] ), FILTER_SANITIZE_STRING );
			}

			$result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities_submitted WHERE activityemployeeid = ' . $activityemployeeid . ' ORDER BY `activitydateperformed` DESC' );


			$activities_html = '<p>Uh-Oh! Looks like there\'s no saved Activities for this employee!</p>';
			foreach ( $result as $key => $activity ) {

				if ( 1 === $key ) {
					$activities_html = '';
				}

				//if ( 'pending' === $activity->activitystatus ) {

					$this->activitiesobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_activities WHERE activityname = "' . $activity->activityname . '"' );

					// Get associated employee info
					$this->userobject = $wpdb->get_row( 'SELECT * FROM ' . $wpdb->prefix . 'medwesthealthpoints_users WHERE useridnumber = ' . $activity->activityemployeeid );

					$supportingdoclink = '';
					$supportingdoctext = '';
					$supportingdocstyle = '';
					if ( null === $activity->activitysupportingdocs || '' === $activity->activitysupportingdocs ) {
						$supportingdoctext = 'No Supporting Documentation Provided!';
						$supportingdoclink = '';
						$supportingdocstyle = 'style="pointer-events:none;"';

					} else {
						$supportingdoctext = 'Click For Supporting Documentation...';
						$supportingdoclink = $activity->activitysupportingdocs;
						$supportingdocstyle = '';
					}

					$activities_html = $activities_html . '
					<div class="medwest-pending-activities-top-indiv-wrapper">
						<div class="medwest-pending-activities-left-wrapper">
							<p class="medwest-pending-activities-left-title">Activity Name: ' . $activity->activityname . '</p>
							<p>Activity Category: ' . ucfirst( $activity->activitycategory ) . '</p>
							<p>Performed on: ' . $activity->activitydateperformed . '</p>
							<p>Activity Status: ' . ucfirst( $activity->activitystatus ) . '</p>
							<p><a ' . $supportingdocstyle . ' target="_blank" href="' . $supportingdoclink . '">' . $supportingdoctext . '</a></p>
						</div>
					</div>';
				//}
			}

		
			wp_die( $activities_html );

		}




		public function medwesthealthpoints_dismiss_activity_denied_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_dismiss_activity_denied_action_callback', 'security' );
			$id = '';

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			error_log('yoyoyoy' . $id);

			$result = $wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_notifications', array( 'ID' => $id ), array( '%d' ) );
			wp_die( $result );

		}

		public function medwesthealthpoints_edit_user_profile_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_edit_user_profile_action_callback', 'security' );
			$id = '';

			$wpuserid     = '';
			$usertableid  = '';
			$usernewemail = '';

			if ( isset( $_POST['wpuserid'] ) ) {
				$wpuserid = filter_var( wp_unslash( $_POST['wpuserid'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			if ( isset( $_POST['usertableid'] ) ) {
				$usertableid = filter_var( wp_unslash( $_POST['usertableid'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			if ( isset( $_POST['usernewemail'] ) ) {
				$usernewemail = filter_var( wp_unslash( $_POST['usernewemail'] ), FILTER_SANITIZE_STRING );
			}

			error_log('yoyoyoyrrrr' . $usernewemail);

			$user_data = wp_update_user( array( 'ID' => $wpuserid, 'user_email' => $usernewemail ) );
 
			if ( is_wp_error( $user_data ) ) {
			    // There was an error; possibly this user doesn't exist.
			    echo 'Error.';
			} else {
			    // Success!
			    echo 'User profile updated.';
			}

			// Now deduct points from the user's points pool.
			$data         = array(
				'useremail' => $usernewemail,
			);
			$format       = array( '%s' );
			$where        = array( 'ID' => $usertableid );
			$where_format = array( '%d' );
			$result = $wpdb->update( $wpdb->prefix . 'medwesthealthpoints_users', $data, $where, $format, $where_format );

			//$result = $wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_notifications', array( 'ID' => $id ), array( '%d' ) );
			wp_die( $result );

		}









		public function medwesthealthpoints_save_activity_user_action_callback() {

			global $wpdb;
			//check_ajax_referer( 'medwesthealthpoints_save_activity_user_action', 'security' );

			$activityname           = '';
			$activitycategory       = '';
			$activitydateperformed  = '';
			$activitysupportingdocs = '';
			$activitywpuserid       = '';
			$activityemployeeid     = '';

			if ( isset( $_POST['activityname'] ) ) {
				$activityname = filter_var( wp_unslash( $_POST['activityname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitycategory'] ) ) {
				$activitycategory = filter_var( wp_unslash( $_POST['activitycategory'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitydateperformed'] ) ) {
				$activitydateperformed = filter_var( wp_unslash( $_POST['activitydateperformed'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitysupportingdocs'] ) ) {
				$activitysupportingdocs = filter_var( wp_unslash( $_POST['activitysupportingdocs'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitywpuserid'] ) ) {
				$activitywpuserid = filter_var( wp_unslash( $_POST['activitywpuserid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activityemployeeid'] ) ) {
				$activityemployeeid = filter_var( wp_unslash( $_POST['activityemployeeid'] ), FILTER_SANITIZE_STRING );
			}


			// Now add the user to the custom table.
			$activitiessubmitted_table_array = array(
				'activityname'           => $activityname,
				'activitycategory'       => $activitycategory,
				'activitydateperformed'  => $activitydateperformed,
				'activitysupportingdocs' => $activitysupportingdocs,
				'activitywpuserid'       => $activitywpuserid,
				'activityemployeeid'     => $activityemployeeid,
				'activitystatus'         => 'pending',
			);

			$activitiessubmitted_table_dbtype_array = array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
			);

			$activitiessubmitted_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_activities_submitted', $activitiessubmitted_table_array, $activitiessubmitted_table_dbtype_array );
			$activitiessubmitted_id           = $wpdb->insert_id;
			wp_die( $activitiessubmitted_id );

		}


		public function medwesthealthpoints_request_reward_user_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_request_reward_user_action_callback', 'security' );

			$rewardrequestwpuserid      = '';
			$rewardrequestfirstlastname = '';
			$rewardrequestrewardsname   = '';
			$rewardrequestdate          = '';
			$rewardrequeststatus        = '';
			$rewardrequestemployeeid    = '';
			$rewardrequestrewardsid     = '';

			if ( isset( $_POST['rewardrequestwpuserid'] ) ) {
				$rewardrequestwpuserid = filter_var( wp_unslash( $_POST['rewardrequestwpuserid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequestfirstlastname'] ) ) {
				$rewardrequestfirstlastname = filter_var( wp_unslash( $_POST['rewardrequestfirstlastname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequestrewardsname'] ) ) {
				$rewardrequestrewardsname = filter_var( wp_unslash( $_POST['rewardrequestrewardsname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequestdate'] ) ) {
				$rewardrequestdate = filter_var( wp_unslash( $_POST['rewardrequestdate'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequeststatus'] ) ) {
				$rewardrequeststatus = filter_var( wp_unslash( $_POST['rewardrequeststatus'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequestemployeeid'] ) ) {
				$rewardrequestemployeeid = filter_var( wp_unslash( $_POST['rewardrequestemployeeid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardrequestrewardsid'] ) ) {
				$rewardrequestrewardsid = filter_var( wp_unslash( $_POST['rewardrequestrewardsid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['leftwith'] ) ) {
				$leftwith = filter_var( wp_unslash( $_POST['leftwith'] ), FILTER_SANITIZE_STRING );
			}


			// Now add the user to the custom table.
			$activitiessubmitted_table_array = array(
				'rewardrequestwpuserid'      => $rewardrequestwpuserid,
				'rewardrequestrewardsid'     => $rewardrequestrewardsid,
				'rewardrequestfirstlastname' => $rewardrequestfirstlastname,
				'rewardrequestrewardsname'   => $rewardrequestrewardsname,
				'rewardrequestdate'          => $rewardrequestdate,
				'rewardrequeststatus'        => $rewardrequeststatus,
				'rewardrequestemployeeid'    => $rewardrequestemployeeid,
				'rewardrequeststatus'        => 'pending',
			);

			$activitiessubmitted_table_dbtype_array = array(
				'%d',
				'%d',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			);

			$activitiessubmitted_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_rewardrequests', $activitiessubmitted_table_array, $activitiessubmitted_table_dbtype_array );
			$activitiessubmitted_id           = $wpdb->insert_id;

			// Now deduct points from the user's points pool.
			$data         = array(
				'userhealthpoints' => $leftwith,
			);
			$format       = array( '%d' );
			$where        = array( 'useridnumber' => $rewardrequestemployeeid );
			$where_format = array( '%d' );
			$wpdb->update( $wpdb->prefix . 'medwesthealthpoints_users', $data, $where, $format, $where_format );

			wp_die( $activitiessubmitted_id );

		}

		public function medwesthealthpoints_approve_activities_user_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_approve_activities_user_action_callback', 'security' );

			$useridnumber     = '';
			$activityid       = '';
			$userhealthpoints = '';

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activityid'] ) ) {
				$activityid = filter_var( wp_unslash( $_POST['activityid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userhealthpoints'] ) ) {
				$userhealthpoints = filter_var( wp_unslash( $_POST['userhealthpoints'] ), FILTER_SANITIZE_STRING );
			}

			// Now add points to the user's points pool.
			$data         = array(
				'userhealthpoints' => $userhealthpoints,
			);
			$format       = array( '%d' );
			$where        = array( 'useridnumber' => $useridnumber );
			$where_format = array( '%d' );
			$wpdb->update( $wpdb->prefix . 'medwesthealthpoints_users', $data, $where, $format, $where_format );

			// Now change the status of the submitted Activity.
			$data         = array(
				'activitystatus' => 'Approved',
			);
			$format       = array( '%s' );
			$where        = array( 'ID' => $activityid );
			$where_format = array( '%d' );
			$wpdb->update( $wpdb->prefix . 'medwesthealthpoints_activities_submitted', $data, $where, $format, $where_format );

			wp_die();

		}

		public function medwesthealthpoints_approve_rewards_user_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_approve_rewards_user_action_callback', 'security' );

			$rewardrequestid = '';

			if ( isset( $_POST['rewardrequestid'] ) ) {
				$rewardrequestid = filter_var( wp_unslash( $_POST['rewardrequestid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useremail'] ) ) {
				$useremail = filter_var( wp_unslash( $_POST['useremail'] ), FILTER_SANITIZE_STRING );
			}

			// Now add points to the user's points pool.
			$data         = array(
				'rewardrequeststatus' => 'Approved',
			);
			$format       = array( '%s' );
			$where        = array( 'ID' => $rewardrequestid );
			$where_format = array( '%d' );
			$wpdb->update( $wpdb->prefix . 'medwesthealthpoints_rewardrequests', $data, $where, $format, $where_format );

			// Now send an email to the user informing them that their reward is ready to pick up
			$to      = $useremail;
			$subject = 'Your HealthPoints Reward is Ready!';
			$body    = 'Congratulations, your Wellness Reward is ready to be picked up in Human Resources! Stop by at your earliest convenience for your Reward.';
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to, $subject, $body, $headers );



			wp_die();

		}



		public function medwesthealthpoints_deny_activities_user_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_deny_activities_user_action_callback', 'security' );

			$activityid = '';

			if ( isset( $_POST['activityid'] ) ) {
				$activityid = filter_var( wp_unslash( $_POST['activityid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useremail'] ) ) {
				$useremail = filter_var( wp_unslash( $_POST['useremail'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['denialreason'] ) ) {
				$denialreason = filter_var( wp_unslash( $_POST['denialreason'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['userwpuserid'] ) ) {
				$userwpuserid = filter_var( wp_unslash( $_POST['userwpuserid'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activityname'] ) ) {
				$activityname = filter_var( wp_unslash( $_POST['activityname'] ), FILTER_SANITIZE_STRING );
			}

			// Now send an email to the user informing them that their Activity was denied, and the reason why.
			$to      = $useremail;
			$subject = 'Your HealthPoints Activity Was Denied!';
			$body    = 'Sorry to be the bearer of bad news, but your HealthPoints Activity was denied! Here\'s the reason why:<br/><br/>' . $denialreason;
			$headers = array('Content-Type: text/html; charset=UTF-8');
			wp_mail( $to, $subject, $body, $headers );

			$wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_activities_submitted', array( 'ID' => $activityid ), array( '%d' ) );



			// Now add the user to the custom table.
			$notification_table_array = array(
				'notificationuseridnumber' => $useridnumber,
				'notificationuserwpuserid' => $userwpuserid,
				'notificationtext'         => $denialreason,
				'notificationtype'         => 'activitydenial',
				'notificationactivityname' => $activityname,
			);

			$notification_table_dbtype_array = array(
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			);

			$notification_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_notifications', $notification_table_array, $notification_table_dbtype_array );
			$user_id                    = $wpdb->insert_id;





			wp_die();

		}

		public function medwesthealthpoints_deny_rewards_user_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_deny_rewards_user_action_callback', 'security' );

			$activityid = '';

			if ( isset( $_POST['useridnumber'] ) ) {
				$useridnumber = filter_var( wp_unslash( $_POST['useridnumber'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			if ( isset( $_POST['userhealthpoints'] ) ) {
				$userhealthpoints = filter_var( wp_unslash( $_POST['userhealthpoints'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			if ( isset( $_POST['rewardrequestid'] ) ) {
				$rewardrequestid = filter_var( wp_unslash( $_POST['rewardrequestid'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_rewardrequests', array( 'ID' => $rewardrequestid ), array( '%d' ) );


			// NOW GIVE THE USER THEIR POINTS BACK.
			$data = array(
				'userhealthpoints'  => $userhealthpoints,
			);
			$format       = array( '%d', );
			$where        = array( 'useridnumber' => $useridnumber );
			$where_format = array( '%s' );
			$results = $wpdb->update( $wpdb->prefix .'medwesthealthpoints_users', $data, $where, $format, $where_format );

			wp_die();

		}

		public function medwesthealthpoints_create_new_reward_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_create_new_reward_action_callback', 'security' );

			$rewardname        = '';
			$rewardpointvalue  = '';
			$rewardimage       = '';
			$rewardurl         = '';
			$rewarddescription = '';

			if ( isset( $_POST['rewardname'] ) ) {
				$rewardname = filter_var( wp_unslash( $_POST['rewardname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardpointvalue'] ) ) {
				$rewardpointvalue = filter_var( wp_unslash( $_POST['rewardpointvalue'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardimage'] ) ) {
				$rewardimage = filter_var( wp_unslash( $_POST['rewardimage'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardurl'] ) ) {
				$rewardurl = filter_var( wp_unslash( $_POST['rewardurl'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewarddescription'] ) ) {
				$rewarddescription = filter_var( wp_unslash( $_POST['rewarddescription'] ), FILTER_SANITIZE_STRING );
			}

			// Now add the user to the custom table.
			$reward_table_array = array(
				'rewardname'        => $rewardname,
				'rewardpointvalue'  => $rewardpointvalue,
				'rewardimage'       => $rewardimage,
				'rewardurl'         => $rewardurl,
				'rewarddescription' => $rewarddescription,
			);

			$reward_table_dbtype_array = array(
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
			);

			$users_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_rewards', $reward_table_array, $reward_table_dbtype_array );
			$user_id            = $wpdb->insert_id;
			wp_die( $user_id );

		}



		// Function for the admin to create a new Activty.
		public function medwesthealthpoints_create_new_activity_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_create_new_activity_action_callback', 'security' );

			$activityname        = '';
			$activitypointsvalue = '';
			$activitycategory    = '';
			$activitysupportingdocsrequired = '';

			if ( isset( $_POST['activityname'] ) ) {
				$activityname = filter_var( wp_unslash( $_POST['activityname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitypointsvalue'] ) ) {
				$activitypointsvalue = filter_var( wp_unslash( $_POST['activitypointsvalue'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			if ( isset( $_POST['activitycategory'] ) ) {
				$activitycategory = filter_var( wp_unslash( $_POST['activitycategory'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitysupportingdocsrequired'] ) ) {
				$activitysupportingdocsrequired = filter_var( wp_unslash( $_POST['activitysupportingdocsrequired'] ), FILTER_SANITIZE_STRING );
			}

			// Now add the user to the custom table.
			$activity_table_array = array(
				'activityname'       => $activityname,
				'activitypointsvalue' => $activitypointsvalue,
				'activitycategory'   => $activitycategory,
				'activitysupportingdocsrequired' => $activitysupportingdocsrequired,
			);

			$activity_table_dbtype_array = array(
				'%s',
				'%d',
				'%s',
				'%s',
			);

			$users_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_activities', $activity_table_array, $activity_table_dbtype_array );
			$user_id            = $wpdb->insert_id;
			wp_die( $user_id );

		}













































		public function medwesthealthpoints_edit_reward_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_edit_reward_action_callback', 'security' );

			$rewardname        = '';
			$rewardpointvalue  = '';
			$rewardimage       = '';
			$rewardurl         = '';
			$rewarddescription = '';
			$id                = '';

			if ( isset( $_POST['rewardname'] ) ) {
				$rewardname = filter_var( wp_unslash( $_POST['rewardname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardpointvalue'] ) ) {
				$rewardpointvalue = filter_var( wp_unslash( $_POST['rewardpointvalue'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardimage'] ) ) {
				$rewardimage = filter_var( wp_unslash( $_POST['rewardimage'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewardurl'] ) ) {
				$rewardurl = filter_var( wp_unslash( $_POST['rewardurl'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['rewarddescription'] ) ) {
				$rewarddescription = filter_var( wp_unslash( $_POST['rewarddescription'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$data = array(
				'rewardname'        => $rewardname,
				'rewardpointvalue'  => $rewardpointvalue,
				'rewardimage'       => $rewardimage,
				'rewardurl'         => $rewardurl,
				'rewarddescription' => $rewarddescription,
			);
			$format       = array( '%s','%d','%s', '%s', '%s');
			$where        = array( 'ID' => $id );
			$where_format = array( '%d' );
			$results = $wpdb->update( $wpdb->prefix .'medwesthealthpoints_rewards', $data, $where, $format, $where_format );
			wp_die( $results );
		}

		// Function to allow admins to delete rewards
		public function medwesthealthpoints_delete_reward_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_delete_reward_action_callback', 'security' );

			$id = '';

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$results = $wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_rewards', array( 'ID' => $id ), array( '%d' ) );
			wp_die( $results );
		}

		// Function to allow admins to delete activitiess
		public function medwesthealthpoints_delete_activity_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_delete_activity_action_callback', 'security' );

			$id = '';

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$results = $wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_activities', array( 'ID' => $id ), array( '%d' ) );
			wp_die( $results );
		}

		// Function to allow admins to delete activitiess
		public function medwesthealthpoints_bulk_upload_users_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_bulk_upload_users_action_callback', 'security' );

			$filename = 'http://healthpoints.local/wp-content/uploads/2019/10/Healthpoints.xlsx-Active-Members.csv';

			// The nested array to hold all the arrays
			$the_big_array = [];

			// Open the file for reading
			if ( ( $h = fopen("{$filename}", "r")) !== FALSE) 
			{

				error_log('tracker1');
			  // Each line in the file is converted into an individual array that we call $data
			  // The items of the array are comma separated
			  while (($data = fgetcsv($h, 1000, ",")) !== FALSE) 
			  {

			  	error_log('tracker2');
			    // Each individual array is being pushed into the nested array
			    $the_big_array[] = $data;		
			  }

			  // Close the file
			  fclose($h);
			}

			// Display the code in a readable format
			echo "<pre>";
			//error_log(print_r($the_big_array,true));
			echo "</pre>";

			foreach ($the_big_array as $key => $array) {
				

error_log('hmm');




// Let's make checks for WordPress user/e-mail already being taken.
			$user_id       = '';
			$usernamecheck = username_exists( $array[2] );
			if ( $usernamecheck ) {
				$error = 'Username Exists';
				//wp_die( $error );
			}
error_log('hmm2');
			if ( email_exists( $array[2] ) ) {
				$error = 'E-Mail Exists';
				//wp_die( $error );
			}

			if ( ! $usernamecheck && false === email_exists( $array[2] ) ) {
				$user_id = wp_create_user( $array[2], $array[3] . '_pass', $array[2] );
				if ( is_wp_error( $user_id ) ) {
					$user_id = 'Unknown error creating WordPress User';
					//wp_die( $user_id );
				} else {

					// Now add the user to the custom table.
					$user_table_array = array(
						'userfirstname'    => $array[0],
						'userlastname'     => $array[1],
						'userjoindate'     => date("m/d/Y"),
						'userwpuserid'     => $user_id,
						'userdepartment'   => '3 East',
						'useridnumber'     => $array[3],
						'userhealthpoints' => $array[4],
						'userlastlogin'    => date("m/d/Y"),
						'useremail'        => $array[2],
					);

					$user_table_dbtype_array = array(
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%s',
						'%d',
						'%s',
						'%s',
						'%d',
					);

					$users_table_result = $wpdb->insert( $wpdb->prefix . 'medwesthealthpoints_users', $user_table_array, $user_table_dbtype_array );
					$user_id            = $wpdb->insert_id;
					//wp_die( $user_id . '--$user_id--' . $array[2] );
				}
			}


















			}











/*
			$id = '';

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}
*/
			//$results = $wpdb->delete( $wpdb->prefix . 'medwesthealthpoints_activities', array( 'ID' => $id ), array( '%d' ) );
			wp_die( '$results' );
		}

		// Function to allow the Admin to edit an existing Activity.
		public function medwesthealthpoints_edit_activity_action_callback() {

			global $wpdb;
			check_ajax_referer( 'medwesthealthpoints_edit_activity_action_callback', 'security' );


			$activityname       = '';
			$activitypointvalue = '';
			$activitycategory   = '';
			$id                 = '';

			if ( isset( $_POST['activityname'] ) ) {
				$activityname = filter_var( wp_unslash( $_POST['activityname'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitypointsvalue'] ) ) {
				$activitypointsvalue = filter_var( wp_unslash( $_POST['activitypointsvalue'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitycategory'] ) ) {
				$activitycategory = filter_var( wp_unslash( $_POST['activitycategory'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['activitysupportingdocsrequired'] ) ) {
				$activitysupportingdocsrequired = filter_var( wp_unslash( $_POST['activitysupportingdocsrequired'] ), FILTER_SANITIZE_STRING );
			}

			if ( isset( $_POST['id'] ) ) {
				$id = filter_var( wp_unslash( $_POST['id'] ), FILTER_SANITIZE_NUMBER_INT );
			}

			$data = array(
				'activityname'        => $activityname,
				'activitypointsvalue' => $activitypointsvalue,
				'activitycategory'    => $activitycategory,
				'activitysupportingdocsrequired' => $activitysupportingdocsrequired,
			);
			$format       = array( '%s','%d','%s','%s' );
			$where        = array( 'ID' => $id );
			$where_format = array( '%d' );
			$results = $wpdb->update( $wpdb->prefix .'medwesthealthpoints_activities', $data, $where, $format, $where_format );
			wp_die( $results );
		}



	}
endif;

/*



function medwesthealthpoints_settings_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

  		$("#medwesthealthpoints-img-remove-1").click(function(event){
  			$('#medwesthealthpoints-preview-img-1').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});

  		$("#medwesthealthpoints-img-remove-2").click(function(event){
  			$('#medwesthealthpoints-preview-img-2').attr('src', '<?php echo ROOT_IMG_ICONS_URL ?>'+'book-placeholder.svg');
  		});



	  	$("#medwesthealthpoints-save-settings").click(function(event){

	  		$('#medwesthealthpoints-success-div').html('');
	  		$('#medwesthpplugin-spinner-storfront-lib').animate({'opacity':'1'});

	  		var callToAction = $('#medwesthealthpoints-call-to-action-input').val();
	  		var libImg = $('#medwesthealthpoints-preview-img-1').attr('src');
	  		var bookImg = $('#medwesthealthpoints-preview-img-2').attr('src');

		  	var data = {
				'action': 'medwesthealthpoints_settings_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_settings_action_callback" ); ?>',
				'calltoaction':callToAction,
				'libimg':libImg,
				'bookimg':bookImg			
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {

			    	$('#medwesthpplugin-spinner-storfront-lib').animate({'opacity':'0'});
			    	$('#medwesthealthpoints-success-div').html('<span id="medwesthpplugin-add-book-success-span">Success!</span><br/><br/> You\'ve saved your MedWestHealthPoints Settings!<div id="medwesthpplugin-addstylepak-success-thanks">Thanks for using WPBooklist! If you happen to be thrilled with MedWesthealthpoints, then by all means, <a id="medwesthpplugin-addbook-success-review-link" href="https://wordpress.org/support/plugin/medwesthpplugin/reviews/?filter=5">Feel Free to Leave a 5-Star Review Here!</a><img id="medwesthpplugin-smile-icon-1" src="http://evansclienttest.com/wp-content/plugins/medwesthpplugin/assets/img/icons/smile.png"></div>')
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}


function medwesthealthpoints_settings_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_settings_action_callback', 'security' );
	$call_to_action = filter_var($_POST['calltoaction'],FILTER_SANITIZE_STRING);
	$lib_img = filter_var($_POST['libimg'],FILTER_SANITIZE_URL);
	$book_img = filter_var($_POST['bookimg'],FILTER_SANITIZE_URL);
	$table_name = MEDWEST_PREFIX.'medwesthealthpoints_jre_toplevel_options';

	if($lib_img == '' || $lib_img == null || strpos($lib_img, 'placeholder.svg') !== false){
		$lib_img = 'Purchase Now!';
	}

	if($book_img == '' || $book_img == null || strpos($book_img, 'placeholder.svg') !== false){
		$book_img = 'Purchase Now!';
	}

	$data = array(
        'calltoaction' => $call_to_action, 
        'libraryimg' => $lib_img, 
        'bookimg' => $book_img 
    );
    $format = array( '%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    echo $wpdb->update( $table_name, $data, $where, $format, $where_format );


	wp_die();
}


function medwesthealthpoints_save_default_action_javascript() { 

	$trans1 = __("Success!", 'medwesthpplugin');
	$trans2 = __("You've saved your default Toplevel WooCommerce Settings!", 'medwesthpplugin');
	$trans6 = __("Thanks for using MedWesthealthpoints, and", 'medwesthpplugin');
	$trans7 = __("be sure to check out the MedWesthealthpoints Extensions!", 'medwesthpplugin');
	$trans8 = __("If you happen to be thrilled with MedWesthealthpoints, then by all means,", 'medwesthpplugin');
	$trans9 = __("Feel Free to Leave a 5-Star Review Here!", 'medwesthpplugin');

	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#medwesthealthpoints-woo-settings-button").click(function(event){

	  		$('#medwesthealthpoints-woo-set-success-div').html('');
	  		$('.medwesthpplugin-spinner').animate({'opacity':'1'});

	  		var salePrice = $( "input[name='book-woo-sale-price']" ).val();
			var regularPrice = $( "input[name='book-woo-regular-price']" ).val();
			var stock = $( "input[name='book-woo-stock']" ).val();
			var length = $( "input[name='book-woo-length']" ).val();
			var width = $( "input[name='book-woo-width']" ).val();
			var height = $( "input[name='book-woo-height']" ).val();
			var weight = $( "input[name='book-woo-weight']" ).val();
			var sku = $("#medwesthpplugin-addbook-woo-sku" ).val();
			var virtual = $("input[name='medwesthpplugin-woocommerce-vert-yes']").prop('checked');
			var download = $("input[name='medwesthpplugin-woocommerce-download-yes']").prop('checked');
			var salebegin = $('#medwesthpplugin-addbook-woo-salebegin').val();
			var saleend = $('#medwesthpplugin-addbook-woo-saleend').val();
			var purchasenote = $('#medwesthpplugin-addbook-woo-note').val();
			var productcategory = $('#medwesthpplugin-woocommerce-category-select').val();
			var reviews = $('#medwesthpplugin-woocommerce-review-yes').prop('checked');
			var upsells = $('#select2-upsells').val();
			var crosssells = $('#select2-crosssells').val();

			var upsellString = '';
			var crosssellString = '';

			// Making checks to see if Toplevel extension is active
			if(upsells != undefined){
				for (var i = 0; i < upsells.length; i++) {
					upsellString = upsellString+','+upsells[i];
				};
			}

			if(crosssells != undefined){
				for (var i = 0; i < crosssells.length; i++) {
					crosssellString = crosssellString+','+crosssells[i];
				};
			}

			if(salebegin != undefined && saleend != undefined){
				// Flipping the sale date start
				if(salebegin.indexOf('-')){
					var finishedtemp = salebegin.split('-');
					salebegin = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}

				// Flipping the sale date end
				if(saleend.indexOf('-')){
					var finishedtemp = saleend.split('-');
					saleend = finishedtemp[0]+'-'+finishedtemp[1]+'-'+finishedtemp[2]
				}	
			}

		  	var data = {
				'action': 'medwesthealthpoints_save_action_default',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_save_default_action_callback" ); ?>',
				'saleprice':salePrice,
				'regularprice':regularPrice,
				'stock':stock,
				'length':length,
				'width':width,
				'height':height,
				'weight':weight,
				'sku':sku,
				'virtual':virtual,
				'download':download,
				'salebegin':salebegin,
				'saleend':saleend,
				'purchasenote':purchasenote,
				'productcategory':productcategory,
				'reviews':reviews,
				'upsells':upsellString,
				'crosssells':crosssellString
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);


			    	$('#medwesthealthpoints-woo-set-success-div').html("<span id='medwesthpplugin-add-book-success-span'><?php echo $trans1 ?></span><br/><br/>&nbsp;<?php echo $trans2 ?><div id='medwesthpplugin-addtemplate-success-thanks'><?php echo $trans6 ?>&nbsp;<a href='http://medwesthpplugin.com/index.php/extensions/'><?php echo $trans7 ?></a><br/><br/>&nbsp;<?php echo $trans8 ?> &nbsp;<a id='medwesthpplugin-addbook-success-review-link' href='https://wordpress.org/support/plugin/medwesthpplugin/reviews/?filter=5'><?php echo $trans9 ?></a><img id='medwesthpplugin-smile-icon-1' src='http://evansclienttest.com/wp-content/plugins/medwesthpplugin/assets/img/icons/smile.png'></div>");

			    	$('.medwesthpplugin-spinner').animate({'opacity':'0'});

			    	$('html, body').animate({
				        scrollTop: $("#medwesthealthpoints-woo-set-success-div").offset().top-100
				    }, 1000);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_save_default_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_save_default_action_callback', 'security' );
	$saleprice = filter_var($_POST['saleprice'],FILTER_SANITIZE_STRING);
	$regularprice = filter_var($_POST['regularprice'],FILTER_SANITIZE_STRING);
	$stock = filter_var($_POST['stock'],FILTER_SANITIZE_STRING);
	$length = filter_var($_POST['length'],FILTER_SANITIZE_STRING);
	$width = filter_var($_POST['width'],FILTER_SANITIZE_STRING);
	$height = filter_var($_POST['height'],FILTER_SANITIZE_STRING);
	$weight = filter_var($_POST['weight'],FILTER_SANITIZE_STRING);
	$sku = filter_var($_POST['sku'],FILTER_SANITIZE_STRING);
	$virtual = filter_var($_POST['virtual'],FILTER_SANITIZE_STRING);
	$download = filter_var($_POST['download'],FILTER_SANITIZE_STRING);
	$woofile = filter_var($_POST['woofile'],FILTER_SANITIZE_STRING);
	$salebegin = filter_var($_POST['salebegin'],FILTER_SANITIZE_STRING);
	$saleend = filter_var($_POST['saleend'],FILTER_SANITIZE_STRING);
	$purchasenote = filter_var($_POST['purchasenote'],FILTER_SANITIZE_STRING);
	$productcategory = filter_var($_POST['productcategory'],FILTER_SANITIZE_STRING);
	$reviews = filter_var($_POST['reviews'],FILTER_SANITIZE_STRING);
	$crosssells = filter_var($_POST['crosssells'],FILTER_SANITIZE_STRING);
	$upsells = filter_var($_POST['upsells'],FILTER_SANITIZE_STRING);


	$data = array(
		'defaultsaleprice' => $saleprice,
		'defaultprice' => $regularprice,
		'defaultstock' => $stock,
		'defaultlength' => $length,
		'defaultwidth' => $width,
		'defaultheight' => $height,
		'defaultweight' => $weight,
		'defaultsku' => $sku,
		'defaultvirtual' => $virtual,
		'defaultdownload' => $download,
		'defaultsalebegin' => $salebegin,
		'defaultsaleend' => $saleend,
		'defaultnote' => $purchasenote,
		'defaultcategory' => $productcategory,
		'defaultreviews' => $reviews,
		'defaultcrosssell' => $crosssells,
		'defaultupsell' => $upsells
	);

 	$table = $wpdb->prefix."medwesthealthpoints_jre_toplevel_options";
   	$format = array( '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s'); 
    $where = array( 'ID' => 1 );
    $where_format = array( '%d' );
    $result = $wpdb->update( $table, $data, $where, $format, $where_format );

	echo $result;



	wp_die();
}


function medwesthealthpoints_upcross_pop_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {

		  	var data = {
				'action': 'medwesthealthpoints_upcross_pop_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_upcross_pop_action_callback" ); ?>',
			};

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	response = response.split('–sep-seperator-sep–');
			    	var upsellstitles = '';
			    	var crosssellstitles = '';


			    	if(response[0] != 'null'){
				    	upsellstitles = response[0];
				    	if(upsellstitles.includes(',')){
				    		var upsellArray = upsellstitles.split(',');
				    	} else {
				    		var upsellArray = upsellstitles;
				    	}

				    	$("#select2-upsells").val(upsellArray).trigger('change');
			    	}

			    	if(response[1] != 'null'){
				    	crosssellstitles = response[1];
				    	if(crosssellstitles.includes(',')){
				    		var upsellArray = crosssellstitles.split(',');
				    	} else {
				    		var upsellArray = crosssellstitles;
				    	}

				    	$("#select2-crosssells").val(upsellArray).trigger('change');
			    	}


			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});


	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_upcross_pop_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_upcross_pop_action_callback', 'security' );
		
	// Get saved settings
    $settings_table = $wpdb->prefix."medwesthealthpoints_jre_toplevel_options";
    $settings = $wpdb->get_row("SELECT * FROM $settings_table");

    echo $settings->defaultupsell.'–sep-seperator-sep–'.$settings->defaultcrosssell;

	wp_die();
}

/*
// For adding a book from the admin dashboard
add_action( 'admin_footer', 'medwesthealthpoints_action_javascript' );
add_action( 'wp_ajax_medwesthealthpoints_action', 'medwesthealthpoints_action_callback' );
add_action( 'wp_ajax_nopriv_medwesthealthpoints_action', 'medwesthealthpoints_action_callback' );


function medwesthealthpoints_action_javascript() { 
	?>
  	<script type="text/javascript" >
  	"use strict";
  	jQuery(document).ready(function($) {
	  	$("#medwesthpplugin-admin-addbook-button").click(function(event){

		  	var data = {
				'action': 'medwesthealthpoints_action',
				'security': '<?php echo wp_create_nonce( "medwesthealthpoints_action_callback" ); ?>',
			};
			console.log(data);

	     	var request = $.ajax({
			    url: ajaxurl,
			    type: "POST",
			    data:data,
			    timeout: 0,
			    success: function(response) {
			    	console.log(response);
			    },
				error: function(jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
		            console.log(textStatus);
		            console.log(jqXHR);
				}
			});

			event.preventDefault ? event.preventDefault() : event.returnValue = false;
	  	});
	});
	</script>
	<?php
}

// Callback function for creating backups
function medwesthealthpoints_action_callback(){
	global $wpdb;
	check_ajax_referer( 'medwesthealthpoints_action_callback', 'security' );
	//$var1 = filter_var($_POST['var'],FILTER_SANITIZE_STRING);
	//$var2 = filter_var($_POST['var'],FILTER_SANITIZE_NUMBER_INT);
	echo 'hi';
	wp_die();
}*/



