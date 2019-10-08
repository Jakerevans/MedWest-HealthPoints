<?php
/**
 * Class MedWestHealthPoints_General_Functions - class-toplevel-general-functions.php
 *
 * @author   Jake Evans
 * @category Admin
 * @package  Includes
 * @version  6.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MedWestHealthPoints_General_Functions', false ) ) :
	/**
	 * MedWestHealthPoints_General_Functions class. Here we'll do things like enqueue scripts/css, set up menus, etc.
	 */
	class MedWestHealthPoints_General_Functions {

		/**
		 *  Functions that loads up all menu pages/contents, etc.
		 */
		public function medwesthealthpoints_jre_admin_page_function() {
			global $wpdb;
			require_once MEDWESTHEALTHPOINTS_ROOT_INCLUDES_UI_ADMIN_DIR . 'class-admin-master-ui.php';
		}

		/** Functions that loads up the menu page entry for this Extension.
		 *
		 *  @param array $submenu_array - The array that contains submenu entries to add to.
		 */
		public function medwesthealthpoints_jre_my_admin_menu() {
			add_menu_page( 'Bell  MedWestHealthPoints', 'MedWest HealthPoints', 'manage_options', 'MedWestHealthPoints-Options', array( $this, 'medwesthealthpoints_jre_admin_page_function' ), MEDWESTHEALTHPOINTS_ROOT_IMG_URL . 'belllogo.svg', 6 );

			$submenu_array = array(
				'Activities',
				'Rewards',
			);

			// Filter to allow the addition of a new subpage.
			if ( has_filter( 'toplevel_add_sub_menu' ) ) {
				$submenu_array = apply_filters( 'toplevel_add_sub_menu', $submenu_array );
			}

			foreach ( $submenu_array as $key => $submenu ) {
				$menu_slug = strtolower( str_replace( ' ', '-', $submenu ) );
				add_submenu_page( 'MedWestHealthPoints-Options', 'MedWestHealthPoints', $submenu, 'manage_options', 'MedWestHealthPoints-Options-' . $menu_slug, array( $this, 'medwesthealthpoints_jre_admin_page_function' ) );
			}

			remove_submenu_page( 'MedWestHealthPoints-Options', 'MedWestHealthPoints-Options' );
		}

		/**
		 *  Here we take the Constant defined in medwesthpplugin.php that holds the values that all our nonces will be created from, we create the actual nonces using wp_create_nonce, and the we define our new, final nonces Constant, called WPPLUGIN_FINAL_NONCES_ARRAY.
		 */
		public function medwesthealthpoints_create_nonces() {

			$temp_array = array();
			foreach ( json_decode( MEDWESTHEALTHPOINTS_NONCES_ARRAY ) as $key => $noncetext ) {
				$nonce              = wp_create_nonce( $noncetext );
				$temp_array[ $key ] = $nonce;
			}

			// Defining our final nonce array.
			define( 'MEDWEST_FINAL_NONCES_ARRAY', wp_json_encode( $temp_array ) );

		}

		/**
		 *  Function to run the compatability code in the Compat class for upgrades/updates, if stored version number doesn't match the defined global in medwesthealthpoints.php
		 */
		public function medwesthealthpoints_update_upgrade_function() {

			// Get current version #.
			global $wpdb;
			$existing_string = $wpdb->get_row( 'SELECT * from ' . $wpdb->prefix . 'medwesthealthpoints_jre_user_options' );

			// Check to see if Extension is already registered and matches this version.
			if ( false !== strpos( $existing_string->extensionversions, 'medwesthealthpoints' ) ) {
				$split_string = explode( 'medwesthealthpoints', $existing_string->extensionversions );
				$version      = substr( $split_string[1], 0, 5 );

				// If version number does not match the current version number found in medwesthpplugin.php, call the Compat class and run upgrade functions.
				if ( MEDWESTHEALTHPOINTS_VERSION_NUM !== $version ) {
					require_once MEDWEST_CLASS_COMPAT_DIR . 'class-toplevel-compat-functions.php';
					$compat_class = new MedWestHealthPoints_Compat_Functions();
				}
			}
		}

		/**
		 * Adding the admin js file
		 */
		public function medwesthealthpoints_admin_js() {

			wp_register_script( 'medwesthealthpoints_adminjs', MEDWESTHEALTHPOINTS_JS_URL . 'medwesthealthpoints_admin.min.js', array( 'jquery' ), MEDWESTHEALTHPOINTS_VERSION_NUM, true );

			global $wpdb;

			$final_array_of_php_values = array();

			// Adding some other individual values we may need.
			$final_array_of_php_values['MEDWESTHEALTHPOINTS_ROOT_IMG_ICONS_URL']   = MEDWESTHEALTHPOINTS_ROOT_IMG_ICONS_URL;
			$final_array_of_php_values['MEDWESTHEALTHPOINTS_ROOT_IMG_URL']   = MEDWESTHEALTHPOINTS_ROOT_IMG_URL;
			$final_array_of_php_values['FOR_TAB_HIGHLIGHT']    = admin_url() . 'admin.php';
			$final_array_of_php_values['SAVED_ATTACHEMENT_ID'] = get_option( 'media_selector_attachment_id', 0 );
			$final_array_of_php_values['SETTINGS_PAGE_URL'] = menu_page_url( 'WPBookList-Options-settings', false );
			$final_array_of_php_values['DB_PREFIX'] = $wpdb->prefix;


			// Now registering/localizing our JavaScript file, passing all the PHP variables we'll need in our $final_array_of_php_values array, to be accessed from 'wpbooklist_php_variables' object (like wpbooklist_php_variables.nameofkey, like any other JavaScript object).
			wp_localize_script( 'medwesthealthpoints_adminjs', 'medwestHealthpointsPhpVariables', $final_array_of_php_values );

			wp_enqueue_script( 'medwesthealthpoints_adminjs' );

		}

		/**
		 * Adding the frontend js file
		 */
		public function medwesthealthpoints_frontend_js() {

			wp_register_script( 'medwesthealthpoints_frontendjs', MEDWESTHEALTHPOINTS_JS_URL . 'medwesthealthpoints_frontend.min.js', array( 'jquery' ), MEDWESTHEALTHPOINTS_VERSION_NUM, true );
			wp_enqueue_script( 'medwesthealthpoints_frontendjs' );

		}

		/**
		 * Adding the admin css file
		 */
		public function medwesthealthpoints_admin_style() {

			wp_register_style( 'medwesthealthpoints_adminui', MEDWESTHEALTHPOINTS_CSS_URL . 'medwesthealthpoints-main-admin.css', null, MEDWESTHEALTHPOINTS_VERSION_NUM );
			wp_enqueue_style( 'medwesthealthpoints_adminui' );

		}

		/**
		 * Adding the frontend css file
		 */
		public function medwesthealthpoints_frontend_style() {

			wp_register_style( 'medwesthealthpoints_frontendui', MEDWESTHEALTHPOINTS_CSS_URL . 'medwesthealthpoint-smain-frontend.css', null, MEDWESTHEALTHPOINTS_VERSION_NUM );
			wp_enqueue_style( 'medwesthealthpoints_frontendui' );

		}

		/**
		 *  Function to add table names to the global $wpdb.
		 */
		public function medwesthealthpoints_register_table_name() {
			global $wpdb;
			$wpdb->medwesthealthpoints_settings = "{$wpdb->prefix}medwesthealthpoints_settings";
			$wpdb->medwesthealthpoints_users = "{$wpdb->prefix}medwesthealthpoints_users";
			$wpdb->medwesthealthpoints_rewards = "{$wpdb->prefix}medwesthealthpoints_rewards";
			$wpdb->medwesthealthpoints_activities = "{$wpdb->prefix}medwesthealthpoints_activities";
			$wpdb->medwesthealthpoints_rewardrequests = "{$wpdb->prefix}medwesthealthpoints_rewardrequests";
		}

		/**
		 *  Function that calls the Style and Scripts needed for displaying of admin pointer messages.
		 */
		public function medwesthealthpoints_admin_pointers_javascript() {
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
		}

		/**
		 *  Runs once upon plugin activation and creates the table that holds info on MedWesthealthpoints Pages & Posts.
		 */
		public function medwesthealthpoints_create_tables() {
			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			global $wpdb;
			global $charset_collate;

			// Call this manually as we may have missed the init hook.
			$this->medwesthealthpoints_register_table_name();

			$sql_create_table1 = "CREATE TABLE {$wpdb->medwesthealthpoints_settings}
			(
				ID bigint(190) auto_increment,
				repw varchar(255),
				PRIMARY KEY  (ID),
				KEY repw (repw)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_settings';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table1 );
				$table_name = $wpdb->prefix . 'medwesthealthpoints_settings';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}

			$sql_create_table2 = "CREATE TABLE {$wpdb->medwesthealthpoints_users}
			(
				ID bigint(190) auto_increment,
				userfirstname varchar(255),
				userlastname varchar(255),
				userlastlogin varchar(255),
				usermotoquote MEDIUMTEXT,
				userhealthpoints bigint(255),
				userrewardsredeemed varchar(255),
				userjoindate varchar(255),
				useridnumber varchar(255),
				userwpuserid varchar(255),
				userphone varchar(255),
				useremail varchar(255),
				userdepartment varchar(255),
				PRIMARY KEY  (ID),
				KEY userfirstname (userfirstname)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_users';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table2 );
				$table_name = $wpdb->prefix . 'medwesthealthpoints_users';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}


			$sql_create_table3 = "CREATE TABLE {$wpdb->medwesthealthpoints_rewards}
			(
				ID bigint(190) auto_increment,
				rewardname varchar(255),
				rewardpointvalue bigint(255),
				rewardimage varchar(255),
				rewardurl varchar(255),
				rewardtotalredeemed bigint(255),
				rewarddescription MEDIUMTEXT,
				PRIMARY KEY  (ID),
				KEY rewardname (rewardname)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_rewards';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table3 );
				$table_name = $wpdb->prefix . 'medwesthealthpoints_rewards';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}


			$sql_create_table4 = "CREATE TABLE {$wpdb->medwesthealthpoints_activities}
			(
				ID bigint(190) auto_increment,
				activityname varchar(255),
				activitycategory varchar(255),
				activitywpuserid bigint(255),
				activitydateperformed varchar(255),
				activitysupportingdocs varchar(255),
				activitystatus varchar(255),
				activityapprovalrequired varchar(255),
				activitysupportingdocsrequired varchar(255),

				PRIMARY KEY  (ID),
				KEY activityname (activityname)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_activities';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table4 );
				$table_name = $wpdb->prefix . 'medwesthealthpoints_activities';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}


			$sql_create_table5 = "CREATE TABLE {$wpdb->medwesthealthpoints_rewardrequests}
			(
				ID bigint(190) auto_increment,
				rewardrequestwpuserid bigint(255),
				rewardrequestfirstlastname varchar(255),
				rewardrequestrewardsid bigint(255),
				rewardrequestrewardsname varchar(255),
				rewardrequestdate varchar(255),
				rewardrequeststatus varchar(255),
				PRIMARY KEY  (ID),
				KEY rewardrequestwpuserid (rewardrequestwpuserid)
			) $charset_collate; ";

			// If table doesn't exist, create table and add initial data to it.
			$test_name = $wpdb->prefix . 'medwesthealthpoints_rewardrequests';
			if ( $test_name !== $wpdb->get_var( "SHOW TABLES LIKE '$test_name'" ) ) {
				dbDelta( $sql_create_table5 );
				$table_name = $wpdb->prefix . 'medwesthealthpoints_rewardrequests';
				$wpdb->insert( $table_name, array( 'ID' => 1, ) );
			}





		}

	}
endif;
